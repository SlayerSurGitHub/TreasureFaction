<?php

namespace Treasure\Faction;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use Treasure\Faction\language\Language;

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
    }

    protected function onEnable(): void
    {
        @mkdir(directory: $this->getDataFolder() . "language");

        new Language(config: new Config(file: $this->getDataFolder() . "language/" . $this->config->get(k: "default_language") . "_language.yml"));
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

}