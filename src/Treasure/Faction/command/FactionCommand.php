<?php

namespace Treasure\Faction\command;

use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\Packet;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use Treasure\Faction\command\argument\CreateCommand;
use Treasure\Faction\command\argument\DisbandCommand;
use Treasure\Faction\command\argument\InviteCommand;
use Treasure\Faction\command\argument\JoinCommand;
use Treasure\Faction\command\argument\PermissionCommand;
use Treasure\Faction\command\argument\PowerCommand;
use Treasure\Faction\command\commando\BaseCommand;
use Treasure\Faction\command\commando\PacketHooker;
use Treasure\Faction\Faction;

final class FactionCommand extends BaseCommand
{
    public function __construct()
    {
        PacketHooker::register(registrant: Faction::getInstance());

        parent::__construct(plugin: Faction::getInstance(), name: "faction", description: "Faction command", aliases: ["f"]);
    }

    protected function prepare(): void
    {
        $this->registerSubCommand(subCommand: new CreateCommand(name: "create", description: "Create a Faction"));
        $this->registerSubCommand(subCommand: new DisbandCommand(name: "disband", description: "Disband my Faction"));
        $this->registerSubCommand(subCommand: new InviteCommand(name: "invite", description: "Invite player"));
        $this->registerSubCommand(subCommand: new JoinCommand(name: "join", description: "Join faction"));
        $this->registerSubCommand(subCommand: new PermissionCommand(name: "permission", description: "Edit permission"));
        $this->registerSubCommand(subCommand: new PowerCommand(name: "power", description: "Get Power"));

        $this->setPermission(permission: DefaultPermissions::ROOT_USER);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        assert(assertion: $sender instanceof Player);
    }

}