<?php

namespace Treasure\Faction\provider\type;


use pocketmine\utils\Config;
use Treasure\Faction\attribute\FactionAttribute;
use Treasure\Faction\event\faction\FactionCreateEvent;
use Treasure\Faction\event\faction\FactionDisbandEvent;

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

        (new FactionCreateEvent(faction: $attribute))->call();

    }

    public function removeFaction(FactionAttribute $attribute): void
    {
        if (!array_key_exists(key: strtolower(string: $attribute->getName()), array: $this->factions))
        {
            return;
        }

        unset($this->factions[strtolower(string: $attribute->getName())]);

        (new FactionDisbandEvent(faction: $attribute))->call();
    }

    public function getFaction(string $username): ?FactionAttribute
    {
        $result = null;

        foreach ($this->factions as $faction)
        {
            if (!$faction->isMember(member: $username)) continue;

            $result = $faction;
            break;
        }

        return $result;
    }

    public function hasFaction(string $username): bool
    {
        return array_reduce(array: $this->factions, callback: function($carry, $faction) use ($username)
        {
            return $carry or $faction->isMember(member: $username);
        }, initial: false);
    }

    public function getFactions(): array
    {
        return $this->factions;
    }

}