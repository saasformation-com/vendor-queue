<?php

namespace SaaSFormation\Vendor\Queue;

class Message
{
    private array $data;
    private array $tags;

    private function __construct(array $data, array $tags)
    {
        $this->data = $data;
        $this->tags = $tags;
    }

    public static function create(array $data, array $tags): static
    {
        return new static($data, $tags);
    }

    public function data(): array
    {
        return $this->data;
    }

    public function tags(): array
    {
        return $this->tags;
    }
}
