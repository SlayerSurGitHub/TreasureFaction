<?php

namespace Treasure\Faction\provider\type;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use Treasure\Faction\player\FactionPlayer;

final class SessionProvider
{
    private array $sessions = [];

    public function __construct
    (
        private Config $config,
    ) {}

    public function loadSessions(): void
    {
        $config = $this->config;
        $result = [];

        foreach ($config->getAll() as $name => $values)
        {
            $result[$name] = FactionPlayer::loadData(jsonSerialize: $values);
        }

        $this->sessions = $result;
    }

    public function saveSessions(): void
    {
        $config = $this->config;
        $result = [];

        foreach ($this->sessions as $name => $values)
        {
            $result[$name] = $values->saveData();
        }

        $config->setAll(v: $result);
        $config->save();
    }

    public function createSession(Player $player): void
    {
        if (array_key_exists(key: $player->getName(), array: $this->sessions))
        {
            return;
        }

        $this->sessions[$player->getName()] = new FactionPlayer(username: $player->getName());
    }

    public function getSession(string $username): ?FactionPlayer
    {
        $result = null;

        if (array_key_exists(key: $username, array: $this->sessions))
        {
            $result = $this->sessions[$username];
        }

        return $result;
    }

}