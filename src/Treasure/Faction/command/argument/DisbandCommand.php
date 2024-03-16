<?php

namespace Treasure\Faction\command\argument;

use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\language\Language;
use Treasure\Faction\language\Translation;
use Treasure\Faction\permission\FactionHolder;
use Treasure\Faction\player\FactionPlayer;
use Treasure\Faction\provider\Provider;

final class DisbandCommand extends ArgumentFactionCommand
{
    protected bool $requiredFaction = true;
    protected int $requiredHolder = FactionHolder::LEADER;

    public function onPostExecute(FactionPlayer $player, ?FactionAttribute $faction, array $args): void
    {
        Provider::FACTION()->removeFaction(attribute: $faction);

        $player->getPlayer()->sendMessage(
            Language::getInstance()->translate(translation: new Translation(key: "command.disbandFaction.message"))
        );
    }

}