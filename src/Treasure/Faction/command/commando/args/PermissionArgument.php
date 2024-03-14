<?php

namespace Treasure\Faction\command\commando\args;

use pocketmine\command\CommandSender;
use Treasure\Faction\permission\FactionPermission;

final class PermissionArgument extends StringEnumArgument
{
    protected const VALUES = [
        FactionPermission::ALL, FactionPermission::MANAGE, FactionPermission::BUILD, FactionPermission::SEARCH, FactionPermission::INTERACT
    ];

    public function getTypeName(): string
    {
        return "permission";
    }

    public function getEnumName(): string
    {
        return "permission";
    }

    public function parse(string $argument, CommandSender $sender): ?string
    {
        return $this->getValue(string: $argument) ?? null;
    }

    public function getValue(string $string): string
    {
        return $string;
    }

    public function getEnumValues(): array
    {
        return array_values(array: self::VALUES);
    }

}
