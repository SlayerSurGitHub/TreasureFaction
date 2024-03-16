<?php

namespace Treasure\Faction\provider;

use pocketmine\utils\Config;
use pocketmine\utils\RegistryTrait;
use pocketmine\utils\SingletonTrait;
use Treasure\Faction\Faction;
use Treasure\Faction\provider\type\FactionProvider;
use Treasure\Faction\provider\type\SessionProvider;

/**
 * @method static FactionProvider FACTION()
 * @method static SessionProvider SESSION()
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
        self::_registryRegister(name: "faction", member: new FactionProvider(config: new Config(file: Faction::getInstance()->getDataFolder() . "provider/faction.json")));
        self::_registryRegister(name: "session", member: new SessionProvider(config: new Config(file: Faction::getInstance()->getDataFolder() . "provider/session.json")));
    }

}