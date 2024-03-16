<?php

namespace Treasure\Faction\player;

use pocketmine\player\Player;
use pocketmine\Server;
use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\event\power\PowerChangeEvent;

final class FactionPlayer
{
    public function __construct
    (
        private readonly string $username,
        private float $power = 0.0,
        private array $requests = []
    ) {}

    public function getPlayer(): ?Player
    {
        return Server::getInstance()->getPlayerExact($this->username);
    }

    public function sendRequest(FactionAttribute $faction): void
    {
        if (!array_key_exists(key: $faction->getName(), array: $this->requests)) $this->requests[$faction->getName()] = time() + 30;
    }

    public function removeRequest(FactionAttribute $faction): void
    {
        if (array_key_exists(key: $faction->getName(), array: $this->requests)) unset($this->requests[array_key_exists(key: $faction->getName(), array: $this->requests)]);
    }

    public function hasRequest(FactionAttribute $faction): bool
    {
        return array_key_exists(key: $faction->getName(), array: $this->requests) and $this->requests[$faction->getName()] > time();
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