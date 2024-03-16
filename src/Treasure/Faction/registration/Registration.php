<?php

namespace Treasure\Faction\registration;

abstract readonly class Registration
{
    public function __construct
    (
        private string $type,
        private array $requirements
    )
    {}

    public function getType(): string
    {
        return $this->type;
    }

    public function getRequirements(): array
    {
        return $this->requirements;
    }

    abstract public function getText(): string;

    public function toText(): string
    {
        return str_replace(search: array_keys(array: $this->requirements), replace: array_values(array: $this->requirements), subject: $this->getText());
    }

}