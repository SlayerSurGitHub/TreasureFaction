<?php

namespace Treasure\Faction;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\command\FactionCommand;
use Treasure\Faction\language\Language;
use Treasure\Faction\permission\FactionHolder;
use Treasure\Faction\provider\Provider;

final class Faction extends PluginBase
{
    use SingletonTrait;

    private Config $config;

    protected function onLoad(): void
    {
        self::setInstance(instance: $this);

        @$this->saveResource(filename: "faction.yml");

        $this->config = new Config(file: $this->getDataFolder() . "faction.yml");

        @$this->saveResource(filename: "language/" . $this->config->get(k: "default_language") ."_language.yml");

        @mkdir(directory: $this->getDataFolder() . "provider");
    }

    protected function onEnable(): void
    {
        @mkdir(directory: $this->getDataFolder() . "language");

        new Language(config: new Config(file: $this->getDataFolder() . "language/" . $this->config->get(k: "default_language") . "_language.yml"));

        Provider::FACTION()->loadFactions();

        $this->getServer()->getCommandMap()->register(fallbackPrefix: "", command: new FactionCommand());
    }

    protected function onDisable(): void
    {
        Provider::FACTION()->saveFactions();
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

}