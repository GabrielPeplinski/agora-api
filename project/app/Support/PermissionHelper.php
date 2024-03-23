<?php

namespace App\Support;

class PermissionHelper
{
    public static function formatPermissions(array $permissions): array
    {
        return array_reduce(array_keys($permissions), function ($carry, $key) use ($permissions) {
            $newValues = array_map(function ($value) use ($key) {
                return $key.' '.$value;
            }, $permissions[$key]);

            return array_merge($carry, $newValues);
        }, []);
    }

    public static function formatRolesAndPermissions(array $permissions)
    {
        return array_reduce(array_keys($permissions), function ($carry, $key) use ($permissions) {
            $newValues = array_map(function ($value) use ($key) {
                return is_array($value) ? array_map(function ($subValue) use ($key) {
                    return $key.' '.$subValue;
                }, $value) : $key.' '.$value;
            }, $permissions[$key]);

            return array_merge($carry, ...$newValues);
        }, []);
    }
}
