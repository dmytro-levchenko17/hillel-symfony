<?php

declare(strict_types=1);

namespace App\Service;

use Michelf\MarkdownInterface;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownService
{
    private CacheInterface $cache;
    private MarkdownInterface $markdown;

    public function __construct(
        CacheInterface $cache,
        MarkdownInterface $markdown,
    ) {
        $this->cache = $cache;
        $this->markdown = $markdown;
    }

    public function parse(string $text): string
    {
        return $this->cache->get(
            md5($text), function (CacheItem $item) use ($text){
                return $this->markdown->transform($text);
            }
        );
    }
} 