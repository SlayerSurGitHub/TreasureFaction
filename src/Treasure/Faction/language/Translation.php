<?php

namespace Treasure\Faction\language;

final readonly class Translation
{
    public function __construct
    (
        private string $key,
        private array  $parameters = [],
    )
    {}

    public function getKey(): string
    {
        return $this->key;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

}