<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 * 
 * @ApiResource(
 *  collectionOperations={"get"={"normalization_context"={"groups"="answer:list"}}},
 *  itemOperations={"get"={"normalization_context"={"groups"="answer:read", "answer:item:get"}}},
 *  attributes={"pagination_items_per_page"="10"},
 * )
 */
class Answer
{
    public const NEEDS_APPROVAL_STATUS = 'needs_approval';
    public const SPAM_STATUS = 'spam';
    public const APPROVED_STATUS = 'approved';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="text")
     * 
     * @Groups({"answer:read", "answer:write"})
     */
    private ?string $content = null;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"answer:read", "answer:write"})
     */
    private ?string $username = null;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private int $votes = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", fieldName="question_id")
     */
    private ?Question $question = null;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private string $status = self::NEEDS_APPROVAL_STATUS;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getVotes(): int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, [static::NEEDS_APPROVAL_STATUS, static::SPAM_STATUS, static::APPROVED_STATUS])) {
            throw new \InvalidArgumentException(sprintf('Invalid status "%s"', $status));
        }

        $this->status = $status;

        return $this;
    }

    public function isApproved(): bool
    {
        return $this->status === static::APPROVED_STATUS;
    }
}