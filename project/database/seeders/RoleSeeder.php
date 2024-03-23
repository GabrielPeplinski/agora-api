<?php

namespace Database\Seeders;

use App\Support\PermissionHelper;
use Database\Seeders\Data\RolesAndPermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = RolesAndPermissions::getRoles();

        foreach ($roles as $role => $permissions) {
           $formattedPermissions = PermissionHelper::formatRolesAndPermissions($permissions);

            $role = app(Role::class)
                ->updateOrCreate([
                    'name' => $role,
                    'guard_name' => 'web',
                ]);

            $role->syncPermissions($formattedPermissions);
        }
    }
}
