<?php

namespace Treasure\Faction\language;

use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

final class Language
{
    use SingletonTrait;

    private Config $config;

    public function __construct(Config $config)
    {
        self::setInstance(instance: $this);

        $this->config = $config;
    }

    public function translate(Translation $translation): string
    {
        if (!array_key_exists(key: $translation->getKey(), array: $this->config->getAll()))
        {
            return $this->translate(translation: new Translation(key: "unknown", parameters: ["{key}" => $translation->getKey()]));
        }

        return str_replace(search: array_keys(array: $translation->getParameters()), replace: array_values(array: $translation->getParameters()), subject: $this->config->get(k: $translation->getKey()));
    }

}