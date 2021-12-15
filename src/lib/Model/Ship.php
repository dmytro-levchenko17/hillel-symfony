<?php

declare(strict_types=1);

namespace App\lib\Model;

class Ship
{
    private ?int $id = null;
    private ?string $name = null;
    private int $weaponPower = 0;
    private int $jediFactor = 0;
    private int $strength = 0;

    public function __construct(string $name, int $weaponPower = 0, int $jediFactor = 0, int $strength = 0) {
        $this->name = $name;
        $this->weaponPower = $weaponPower;
        $this->jediFactor = $jediFactor;
        $this->strength = $strength;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getWeaponPower(): int
    {
        return $this->weaponPower;
    }

    public function setWeaponPower(int $weaponPower): self
    {
        $this->weaponPower = $weaponPower;
        return $this;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): self
    {
        $this->strength = $strength;
        return $this;
    }

    public function getJediFactor(): int
    {
        return $this->jediFactor;
    }

    public function setJediFactor(int $jediFactor): self
    {
        $this->jediFactor = $jediFactor;
        return $this;
    }

    public function getNameAndSpecs(bool $useShortFormat = false): string
    {
        if ($useShortFormat) {
            return sprintf(
                '%s: %s/%s/%s',
                $this->getName(),
                $this->getWeaponPower(),
                $this->getJediFactor(),
                $this->getStrength()
            );
        }

        return sprintf(
            '%s (w: %s, j: %s, s: %s)',
            $this->getName(),
            $this->getWeaponPower(),
            $this->getJediFactor(),
            $this->getStrength()
        );
    }
}
