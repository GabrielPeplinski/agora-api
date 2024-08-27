<?php

namespace Database\Seeders\Data;

use App\Domains\Shared\Enums\RolesEnum;
use Illuminate\Support\Collection;

abstract class RolesAndPermissions
{
    public static function getAllPermissions(): Collection
    {
        return collect([
            'address' => [
                'view',
                'update'
            ],

            'my-solicitations' => [
                'create',
                'view any',
                'view',
                'update',
                'delete',
            ],

            'solicitations' => [
                'view any',
                'view',
                'like'
            ],

            'dashboard' => [
                'view any',
            ],
        ]);
    }

    private static function getPermissionsValues(): callable
    {
        return function ($key) {
            return collect(static::getAllPermissions()->get($key, []))->values();
        };
    }

    public static function getClientPermissions(): array
    {
        $permissions = static::getPermissionsValues();

        return [
            'address' => $permissions('address'),
            'my-solicitations' => $permissions('my-solicitations'),
            'solicitations' => $permissions('solicitations'),
            'dashboard' => $permissions('dashboard'),
        ];
    }

    public static function getPermissionsByRole(): array
    {
        return [
            RolesEnum::CLIENT => self::getClientPermissions(),
        ];
    }
}
