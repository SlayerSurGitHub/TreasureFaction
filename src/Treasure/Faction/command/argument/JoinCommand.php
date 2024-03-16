<?php

namespace Treasure\Faction\command\argument;

use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\command\commando\args\RawStringArgument;
use Treasure\Faction\Faction;
use Treasure\Faction\language\Language;
use Treasure\Faction\language\Translation;
use Treasure\Faction\permission\FactionPermission;
use Treasure\Faction\player\FactionPlayer;
use Treasure\Faction\provider\Provider;

final class JoinCommand extends ArgumentFactionCommand
{
    protected bool $requiredFaction = false;

    protected function prepare(): void
    {
        parent::prepare();

        $this->registerArgument(position: 0, argument: new RawStringArgument(name: "faction", optional: false));
    }

    public function onPostExecute(FactionPlayer $player, ?FactionAttribute $faction, array $args): void
    {
        $targetFaction = Provider::FACTION()->getFaction(name: $args["faction"]);

        if (is_null(value: $targetFaction))
        {
            $player->getPlayer()->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "faction.untraceable.message"))
            );
            return;
        }

        if (count(value: $targetFaction->getMembers(true)) >= Faction::getInstance()->getConfig()->get("faction")["limits"]["member"])
        {
            $player->getPlayer()->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "faction.maxMember.message", parameters: ["{limit}" => Faction::getInstance()->getConfig()->get("faction")["limits"]["member"]]))
            );
            return;
        }

        if (!$player->hasRequest(faction: $targetFaction))
        {
            $player->getPlayer()->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "request.noReceive.message"))
            );
            return;
        }

        $player->removeRequest($targetFaction);
        $targetFaction->addMember(username: $player->getPlayer()->getName());

        $player->getPlayer()->sendMessage(
            Language::getInstance()->translate(translation: new Translation(key: "command.joinFaction.message"))
        );
    }

}