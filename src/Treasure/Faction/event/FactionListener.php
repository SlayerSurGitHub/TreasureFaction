<?php

namespace Treasure\Faction\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use Treasure\Faction\provider\Provider;

final class FactionListener implements Listener
{
    public function onPlayerLoginEvent(PlayerLoginEvent $event): void
    {
        $player = $event->getPlayer();

        Provider::SESSION()->createSession(player: $player);
    }

}