<?php

namespace Database\Seeders;

use Database\Seeders\Data\RolesAndPermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = $this->formatPermissionsData();

        foreach ($permissions as $permission) {
            app(Permission::class)
                ->firstOrCreate([
                    'name' => $permission
                ]);
        }

        $this->dropUnusedPermissions($permissions);
    }

    private function formatPermissionsData(): array
    {
        $permissions = RolesAndPermissions::getPermissions();

        return array_reduce(array_keys($permissions), function ($carry, $key) use ($permissions) {
            $newValues = array_map(function ($value) use ($key) {
                return $key . ' ' . $value;
            }, $permissions[$key]);

            return array_merge($carry, $newValues);
        }, []);
    }

    private function dropUnusedPermissions(array $permissions): void
    {
        app(Permission::class)
            ->whereNotIn('name', $permissions)
            ->delete();
    }
}
