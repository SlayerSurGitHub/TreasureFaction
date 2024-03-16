<?php

namespace Treasure\Faction\command\argument;

use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\command\commando\args\BooleanArgument;
use Treasure\Faction\command\commando\args\HolderArgument;
use Treasure\Faction\command\commando\args\PermissionArgument;
use Treasure\Faction\language\Language;
use Treasure\Faction\language\Translation;
use Treasure\Faction\permission\FactionHolder;
use Treasure\Faction\player\FactionPlayer;

final class PermissionCommand extends ArgumentFactionCommand
{
    protected function prepare(): void
    {
        parent::prepare();

        $this->registerArgument(position: 0, argument: new HolderArgument(name: "holder", optional: false));
        $this->registerArgument(position: 1, argument: new PermissionArgument(name: "permission", optional: false));
        $this->registerArgument(position: 2, argument: new BooleanArgument(name: "value", optional: false));
    }

    public function onPostExecute(FactionPlayer $player, ?FactionAttribute $faction, array $args): void
    {
        $faction->setPermission(
            holder: match ($args["holder"])
            {
                "leader" => FactionHolder::LEADER,
                "officer" => FactionHolder::OFFICER,
                "member" => FactionHolder::MEMBER,
                "alliance" => FactionHolder::ALLIANCE,
                default => FactionHolder::RECRUIT
            }, permission: $args["permission"], value: $args["value"]
        );

        $player->getPlayer()->sendMessage(
            Language::getInstance()->translate(translation: new Translation(key: "command.permissionUpdate.message", parameters: ["{holder}" => $args["holder"]]))
        );
    }

}