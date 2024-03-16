<?php

namespace Treasure\Faction\event\faction;

use pocketmine\event\Event;
use Treasure\Faction\attribute\FactionAttribute;

final class FactionCreateEvent extends Event
{
    public function __construct
    (
        private readonly FactionAttribute $faction,
    )
    {}

    public function getFaction(): FactionAttribute
    {
        return $this->faction;
    }

}