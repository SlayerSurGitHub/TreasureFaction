<?php

namespace Treasure\Faction\player;

use pocketmine\player\Player;
use pocketmine\Server;

final class FactionPlayer implements \JsonSerializable
{
    public function __construct
    (
        private readonly string $username,
        private float $power = 0.0,
    )
    {}

    public function getPlayer(): ?Player
    {
        return Server::getInstance()->getPlayerExact($this->username);
    }

    public function setPower(float $power): void
    {
        $this->power += $power;
    }

    public function getPower(): float
    {
        return $this->power;
    }

    public static function jsonUnserialize(array $jsonSerialize): self
    {
        return new self(username: $jsonSerialize["username"], power: $jsonSerialize["power"]);
    }

    public function jsonSerialize(): array
    {
        return [
            "username" => $this->username,
            "power" => $this->power
        ];
    }

}