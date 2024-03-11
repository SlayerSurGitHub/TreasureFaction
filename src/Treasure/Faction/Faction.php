<?php

namespace Treasure\Faction;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

final class Faction extends PluginBase
{
    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        parent::onEnable();
    }

    protected function onDisable(): void
    {
        parent::onDisable();
    }

}