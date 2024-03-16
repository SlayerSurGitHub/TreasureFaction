<?php

namespace Treasure\Faction\event;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\player\Player;
use Treasure\Faction\Faction;
use Treasure\Faction\provider\Provider;

final class FactionListener implements Listener
{
    private Faction $faction;

    public function __construct(Faction $faction)
    {
        $this->faction = $faction;
    }

    public function onPlayerLoginEvent(PlayerLoginEvent $event): void
    {
        $player = $event->getPlayer();

        Provider::SESSION()->createSession(player: $player);
    }

    public function onPlayerDeathEvent(PlayerDeathEvent $event): void
    {
        $player = $event->getPlayer();
        $killer = ($cause = $player->getLastDamageCause()) instanceof EntityDamageByEntityEvent ? $cause->getDamager() : null;

        if (!$killer instanceof Player) return;

        Provider::SESSION()->getSession($player->getName())?->reducePower($this->faction->getConfig()->get(k: "power")["gain_per_kill"]);
        Provider::SESSION()->getSession($killer->getName())?->addPower($this->faction->getConfig()->get(k: "power")["lost_per_death"]);
    }

}