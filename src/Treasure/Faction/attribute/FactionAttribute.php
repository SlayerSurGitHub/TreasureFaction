<?php

namespace Treasure\Faction\attribute;

use Treasure\Faction\permission\FactionHolder;
use Treasure\Faction\permission\FactionPermission;

final class FactionAttribute implements \JsonSerializable
{
    public function __construct
    (
        private string $name,
        private array $members = [
            FactionHolder::LEADER => [],
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

    public function addMember(string $username, ?int $holder = null): void
    {
        $this->members[$holder ?? FactionHolder::RECRUIT][] = $username;
    }

    public function removeMember(string $username): void
    {
        array_walk(array: $this->members, callback: function (&$values) use ($username): void
        {
            if (in_array(needle: $username, haystack: $values)) unset($values[array_search(needle: $username, haystack: $values)]);
        });
    }

    public function isMember(string $username): bool
    {
        return array_reduce(array: $this->members, callback: function($carry, $values) use ($username)
        {
            return $carry or in_array(needle: $username, haystack: $values);
        }, initial: false);
    }

    public function getMembers(): array
    {
        return $this->members;
    }

    public function getHolder(string $username): int
    {
        return array_search(needle: $username, haystack: array_column(array: $this->members, column_key: null,  index_key: 0)) ?: FactionHolder::RECRUIT;
    }

    public function setPermission(string $holder, string $permission, bool $value): void
    {
        if (in_array(needle: $permission, haystack: $this->permissions[$holder]))
        {
            if ($value) return;

            unset($this->permissions[$holder][array_search(needle: $permission, haystack: $this->permissions[$holder])]);
        }
        elseif ($value)
        {
            $this->permissions[$holder][] = $permission;
        }

    }

    public function hasPermission(string $holder, string $permission): bool
    {
        return in_array(needle: $permission, haystack: $this->permissions[$holder]) or in_array(needle: FactionPermission::ALL, haystack: $this->permissions[$holder]);
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public static function jsonUnserialize(array $jsonSerialize): self
    {
        return new self($jsonSerialize["name"], $jsonSerialize["members"], $jsonSerialize["permissions"]);
    }

    public function jsonSerialize(): array
    {
        return [
            "name" => $this->name,
            "members" => $this->members,
            "permissions" => $this->permissions,
        ];
    }

}