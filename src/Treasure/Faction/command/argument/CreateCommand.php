<?php

namespace Treasure\Faction\command\argument;

use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\command\commando\args\RawStringArgument;
use Treasure\Faction\language\Language;
use Treasure\Faction\language\Translation;
use Treasure\Faction\permission\FactionHolder;
use Treasure\Faction\player\FactionPlayer;
use Treasure\Faction\provider\Provider;

final class CreateCommand extends ArgumentFactionCommand
{
    protected const REQUIRED_FACTION = false;

    protected function prepare(): void
    {
        parent::prepare();

        $this->registerArgument(position: 0, argument: new RawStringArgument(name: "name", optional: false));
    }

    public function onPostExecute(FactionPlayer $player, ?FactionAttribute $faction, array $args): void
    {
        $factionName = $args["name"];

        if (strlen(string: $factionName) < 4 or strlen(string: $factionName) > 12 or !ctype_alnum($factionName))
        {
            $player->getPlayer()->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "command.haveFaction.message"))
            );
            return;
        }

        if (!ctype_alnum($factionName))
        {
            $player->getPlayer()->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "command.haveFaction.message"))
            );
            return;
        }

        if (array_key_exists(key: strtolower(string: $factionName), array: Provider::FACTION()->getFactions()))
        {
            $player->getPlayer()->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "command.alreadyFactionExist.message"))
            );
            return;
        }

        $faction = new FactionAttribute(name: $factionName);
        $faction->addMember(username: $player->getPlayer()->getName(), holder: FactionHolder::LEADER);

        Provider::FACTION()->addFaction(attribute: $faction);

        $player->getPlayer()->sendMessage(
            Language::getInstance()->translate(translation: new Translation(key: "command.createFaction.message", parameters: ["{faction}" => $factionName]))
        );
    }

}