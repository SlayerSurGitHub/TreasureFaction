<?php

namespace Treasure\Faction;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

final class Faction extends PluginBase
{
    use SingletonTrait;

    private Config $config;

    protected function onLoad(): void
    {
        self::setInstance(instance: $this);

        @$this->saveResource(filename: "faction.yml");

        $this->config = new Config(file: $this->getDataFolder() . "faction.yml");
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

}