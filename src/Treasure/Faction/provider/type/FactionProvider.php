<?php

namespace Treasure\Faction\provider\type;


use pocketmine\utils\Config;
use Treasure\Faction\attribute\FactionAttribute;

final class FactionProvider
{
    private array $factions = [];

    public function __construct
    (
        private Config $config,
    ) {}

    public function loadFactions(): void
    {
        $config = $this->config;
        $result = [];

        foreach ($config->getAll() as $name => $values)
        {
            $result[$name] = FactionAttribute::jsonUnserialize(jsonSerialize: $values);
        }

        $this->factions = $result;
    }

    public function saveFactions(): void
    {
        $config = $this->config;
        $result = [];

        foreach ($this->factions as $name => $values)
        {
            $result[$name] = $values->jsonSerialize();
        }

        $config->setAll(v: $result);
        $config->save();
    }

    public function addFaction(FactionAttribute $attribute): void
    {
        if (array_key_exists(key: strtolower(string: $attribute->getName()), array: $this->factions))
        {
            return;
        }

        $this->factions[strtolower(string: $attribute->getName())] = $attribute;
    }

    public function getFactions(): array
    {
        return $this->factions;
    }

}