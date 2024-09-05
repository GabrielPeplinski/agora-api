<?php

namespace Database\Seeders;

use Database\Seeders\Data\RolesAndPermissions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->updatePermissions();
        $this->updateUserRoles();
    }

    private function updatePermissions(): void
    {
        try {
            DB::beginTransaction();

            $permissions = RolesAndPermissions::getAllPermissions();

            foreach ($permissions as $entity => $actions) {
                foreach ($actions as $action) {
                    $permissionName = "{$entity} {$action}";

                    Permission::updateOrCreate([
                        'name' => $permissionName,
                        'guard_name' => 'web',
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            Log::error('Error updating permissions: ' . $exception->getMessage());
            DB::rollBack();
        }
    }

    private function updateUserRoles(): void
    {
        try {
            DB::beginTransaction();

            $rolesAndPermissions = RolesAndPermissions::getPermissionsByRole();

            foreach ($rolesAndPermissions as $role => $permissionsArray) {
                $roleModel = Role::updateOrCreate(
                    ['name' => $role],
                    ['name' => $role]
                );

                $formattedPermissions = [];

                foreach ($permissionsArray as $entity => $actions) {
                    foreach ($actions as $action) {
                        $formattedPermissions[] = "{$entity} {$action}";
                    }
                }

                $roleModel->syncPermissions($formattedPermissions);
            }

            DB::commit();
        } catch (\Exception $exception) {
            Log::error('Error updating permissions: ' . $exception->getMessage());
            DB::rollBack();
        }
    }
}
