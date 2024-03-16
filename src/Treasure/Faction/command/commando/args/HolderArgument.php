<?php

namespace Treasure\Faction\command\commando\args;

use pocketmine\command\CommandSender;
use Treasure\Faction\permission\FactionHolder;

final class HolderArgument extends StringEnumArgument
{
    protected const VALUES = [
        "leader", "officer", "member", "recruit", "alliance"
    ];

    public function getTypeName(): string
    {
        return "holder";
    }

    public function getEnumName(): string
    {
        return "holder";
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
