<?php

namespace Treasure\Faction\event\power;

use pocketmine\event\Event;
use Treasure\Faction\player\FactionPlayer;

final class PowerChangeEvent extends Event
{
    public function __construct
    (
        private readonly FactionPlayer $player,
        private readonly float $newPower,
        private readonly float $oldPower,
    )
    {}

    public function getPlayer(): FactionPlayer
    {
        return $this->player;
    }

    public function getNewPower(): float
    {
        return $this->newPower;
    }

    public function getOldPower(): float
    {
        return $this->oldPower;
    }

}