<?php

namespace Treasure\Faction\command;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use Treasure\Faction\command\argument\CreateCommand;
use Treasure\Faction\command\argument\DisbandCommand;
use Treasure\Faction\command\commando\BaseCommand;
use Treasure\Faction\Faction;

final class FactionCommand extends BaseCommand
{
    public function __construct()
    {
        parent::__construct(plugin: Faction::getInstance(), name: "faction", description: "Faction command", aliases: ["f"]);
    }

    protected function prepare(): void
    {
        $this->registerSubCommand(subCommand: new CreateCommand(name: "create", description: "Create a Faction"));
        $this->registerSubCommand(subCommand: new DisbandCommand(name: "disband", description: "Disband my Faction"));

        $this->setPermission(permission: DefaultPermissions::ROOT_USER);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        assert(assertion: $sender instanceof Player);
    }

}