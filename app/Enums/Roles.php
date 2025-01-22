<?php

namespace App\Enums;

enum Roles: string
{
    case TEAMLEADER = 'teamleader';
    case MEMBER = 'member';
    case ADMIN = 'admin';

    public static function getRoles(): array
    {
        return [
            self::TEAMLEADER,
            self::MEMBER,
            self::ADMIN,
        ];
    }

    public static function getRole(string $role): string
    {
        return match ($role) {
            self::TEAMLEADER => 'teamleader',
            self::MEMBER => 'member',
            self::ADMIN => 'admin',
            default => 'unknown',
        };
    }
}
