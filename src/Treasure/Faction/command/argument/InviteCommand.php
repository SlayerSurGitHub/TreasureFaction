<?php

namespace Treasure\Faction\command\argument;

use pocketmine\player\Player;
use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\command\commando\args\TargetPlayerArgument;
use Treasure\Faction\Faction;
use Treasure\Faction\language\Language;
use Treasure\Faction\language\Translation;
use Treasure\Faction\permission\FactionPermission;
use Treasure\Faction\player\FactionPlayer;
use Treasure\Faction\provider\Provider;

final class InviteCommand extends ArgumentFactionCommand
{
    protected ?string $requiredPermission = FactionPermission::MANAGE;

    protected function prepare(): void
    {
        parent::prepare();

        $this->registerArgument(position: 0, argument: new TargetPlayerArgument(name: "player", optional: false));
    }

    public function onPostExecute(FactionPlayer $player, ?FactionAttribute $faction, array $args): void
    {
        $factionTarget = Provider::SESSION()->getSession($args["player"]);

        if (count(value: $faction->getMembers(true)) >= Faction::getInstance()->getConfig()->get("faction")["limits"]["member"])
        {
            $player->getPlayer()->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "faction.maxMember.message", parameters: ["{limit}" => Faction::getInstance()->getConfig()->get("faction")["limits"]["member"]]))
            );
            return;
        }

        if (is_null(value: $factionTarget))
        {
            $player->getPlayer()->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "session.invalid.message"))
            );
            return;
        }

        if (!$factionTarget->getPlayer() instanceof Player)
        {
            $player->getPlayer()->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "session.invalid.message"))
            );
            return;
        }

        $factionTarget->sendRequest($faction);

        $player->getPlayer()->sendMessage(
            Language::getInstance()->translate(translation: new Translation(key: "request.factionSend.message", parameters: ["{username}" => $factionTarget->getPlayer()->getName()]))
        );
        $factionTarget->getPlayer()->sendMessage(
            Language::getInstance()->translate(translation: new Translation(key: "request.factionReceive.message", parameters: ["{faction}" => $faction->getName()]))
        );
    }

}