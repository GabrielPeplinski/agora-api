<?php

namespace Database\Seeders\Data;

use App\Domains\Shared\Enums\RolesEnum;

abstract class RolesAndPermissions
{
    public static function getRoles(): array
    {
        return [
            RolesEnum::CLIENT => self::getClientPermissions(),
        ];
    }

    public static function getPermissions(): array
    {
        return [
            'solicitations' => [
                'create',
                'update',
                'delete',
            ],
        ];
    }

    public static function getClientPermissions(): array
    {
        $permissions = self::getPermissions();

        return [
            'solicitations' => [
               $permissions['solicitations'],
            ],
        ];
    }
}
