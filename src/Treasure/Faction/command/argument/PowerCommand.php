<?php

namespace Treasure\Faction\command\argument;

use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\language\Language;
use Treasure\Faction\language\Translation;
use Treasure\Faction\player\FactionPlayer;
use Treasure\Faction\provider\Provider;

final class PowerCommand extends ArgumentFactionCommand
{
    protected bool $requiredFaction = false;

    public function onPostExecute(FactionPlayer $player, ?FactionAttribute $faction, array $args): void
    {
        $player->getPlayer()->sendMessage(
            Language::getInstance()->translate(translation: new Translation(key: "command.powerFaction.message", parameters: ["{power}" => $player->getPower()]))
        );
    }

}