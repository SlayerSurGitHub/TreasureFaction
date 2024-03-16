<?php

namespace Treasure\Faction\command\argument;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\command\commando\BaseSubCommand;
use Treasure\Faction\Faction;
use Treasure\Faction\language\Language;
use Treasure\Faction\language\Translation;
use Treasure\Faction\permission\FactionHolder;
use Treasure\Faction\player\FactionPlayer;
use Treasure\Faction\provider\Provider;

abstract class ArgumentFactionCommand extends BaseSubCommand
{
    protected const REQUIRED_FACTION = true;
    protected const REQUIRED_HOLDER = FactionHolder::RECRUIT;
    protected const REQUIRED_PERMISSION = null;

    public function __construct(string $name, string $description = "", array $aliases = [])
    {
        parent::__construct(plugin: Faction::getInstance(), name: $name, description: $description, aliases: $aliases);
    }

    protected function prepare(): void
    {
        $this->setPermission(permission: DefaultPermissions::ROOT_USER);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        assert(assertion: $sender instanceof Player);

        $hasFaction = Provider::FACTION()->hasFaction(username: $sender->getName());

        if (self::REQUIRED_FACTION)
        {
            if (!$hasFaction)
            {
                $sender->sendMessage(
                    Language::getInstance()->translate(translation: new Translation(key: "command.requiredFaction.message", parameters: ["{command}" => $this->getName()]))
                );
                return;
            }

            $faction = Provider::FACTION()->getFaction(username: $sender->getName());

            if ($faction->getHolder(username: $sender->getName()) < self::REQUIRED_HOLDER)
            {
                $sender->sendMessage(
                    Language::getInstance()->translate(translation: new Translation(key: "command.lowHolder.message"))
                );
                return;
            }

            if (!is_null(value: self::REQUIRED_PERMISSION))
            {
                if (!$faction->hasPermission(holder: $faction->getHolder(username: $sender->getName()), permission: self::REQUIRED_PERMISSION))
                {
                    $sender->sendMessage(
                        Language::getInstance()->translate(translation: new Translation(key: "command.lowHolder.message"))
                    );
                    return;
                }

            }

        }
        elseif ($hasFaction)
        {
            $sender->sendMessage(
                Language::getInstance()->translate(translation: new Translation(key: "command.haveFaction.message"))
            );
            return;
        }

        $this->onPostExecute(player: Provider::SESSION()->getSession(username: $sender->getName()), faction: $hasFaction ? $faction : null, args: $args);
    }

    abstract public function onPostExecute(FactionPlayer $player, ?FactionAttribute $faction, array $args): void;
}