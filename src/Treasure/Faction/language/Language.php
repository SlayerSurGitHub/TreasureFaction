<?php

namespace Treasure\Faction\language;

use pocketmine\utils\SingletonTrait;

final class Language
{
    use SingletonTrait;

    public function __construct()
    {
        self::setInstance(instance: $this);
    }

}