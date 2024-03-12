<?php

namespace Treasure\Faction\provider;

use pocketmine\utils\RegistryTrait;
use pocketmine\utils\SingletonTrait;
use Treasure\Faction\provider\type\FactionProvider;

/**
 * @method static FactionProvider FACTION()
 */

final class Provider
{
    use SingletonTrait, RegistryTrait;

    public function __construct()
    {
        self::setInstance(instance: $this);
    }

    protected static function setup(): void
    {
        self::_registryRegister(name: "faction", member: new FactionProvider());
    }

}