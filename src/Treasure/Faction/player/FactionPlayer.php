<?php

namespace Treasure\Faction\player;

use pocketmine\player\Player;
use pocketmine\Server;
use Treasure\Faction\event\power\PowerChangeEvent;

final class FactionPlayer
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

    public function addPower(float $power): void
    {
        $this->power += $power;

        (new PowerChangeEvent(player: $this, newPower: $this->power, oldPower: ($this->power - $power)))->call();
    }

    public function reducePower(float $power): void
    {
        $this->power -= $power;

        (new PowerChangeEvent(player: $this, newPower: $this->power, oldPower: ($this->power + $power)))->call();
    }

    public function getPower(): float
    {
        return $this->power;
    }

    public static function loadData(array $jsonSerialize): self
    {
        return new self(username: $jsonSerialize["username"], power: $jsonSerialize["power"]);
    }

    public function saveData(): array
    {
        return [
            "username" => $this->username,
            "power" => $this->power
        ];
    }

}