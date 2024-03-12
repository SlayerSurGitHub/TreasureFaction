<?php

namespace Treasure\Faction\attribute;

use Treasure\Faction\permission\FactionHolder;
use Treasure\Faction\permission\FactionPermission;

final class FactionAttribute
{
    public function __construct
    (
        private string $name,
        private array $members = [
            FactionHolder::LEADER => null,
            FactionHolder::OFFICER => [], FactionHolder::MEMBER => [], FactionHolder::RECRUIT => []
        ],
        private array $permissions = [
            FactionHolder::LEADER => [FactionPermission::ALL], FactionHolder::OFFICER => [FactionPermission::ALL],
            FactionHolder::MEMBER => [FactionPermission::BUILD, FactionPermission::INTERACT, FactionPermission::SEARCH],
            FactionHolder::RECRUIT => [FactionPermission::INTERACT]
        ],
    )
    {}

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addMember(string $username, ?string $holder = null): void
    {
        $this->members[$holder ?? FactionHolder::RECRUIT][] = $username;
    }

    public function getMembers(): array
    {
        return $this->members;
    }

    public function addPermission(string $holder, string $permission): void
    {
        if (in_array(needle: $permission, haystack: $this->permissions[$holder]))
        {
            return;
        }

        $this->permissions[$holder][] = $permission;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

}