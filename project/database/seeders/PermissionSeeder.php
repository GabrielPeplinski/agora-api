<?php

namespace Database\Seeders;

use App\Support\PermissionHelper;
use Database\Seeders\Data\RolesAndPermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = RolesAndPermissions::getPermissions();
        $formattedPermissions = PermissionHelper::formatPermissions($permissions);

        foreach ($formattedPermissions as $permission) {
            app(Permission::class)
                ->firstOrCreate([
                    'name' => $permission
                ]);
        }

        $this->dropUnusedPermissions($formattedPermissions);
    }

    private function dropUnusedPermissions(array $permissions): void
    {
        app(Permission::class)
            ->whereNotIn('name', $permissions)
            ->delete();
    }
}
