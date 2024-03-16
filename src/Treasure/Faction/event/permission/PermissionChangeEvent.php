<?php

namespace Treasure\Faction\event\permission;

use pocketmine\event\Event;
use Treasure\Faction\attribute\FactionAttribute;

final class PermissionChangeEvent extends Event
{
    public function __construct
    (
        private readonly FactionAttribute $faction,
        private readonly int $holder,
        private readonly string $permission,
        private readonly bool $value
    )
    {}

    public function getFaction(): FactionAttribute
    {
        return $this->faction;
    }

    public function getHolder(): int
    {
        return $this->holder;
    }

    public function getPermission(): string
    {
        return $this->permission;
    }

    public function getValue(): bool
    {
        return $this->value;
    }

}