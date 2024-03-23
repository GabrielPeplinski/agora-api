<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UpdateSeeder extends Seeder
{
    /**
     * Update the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class
        ]);
    }
}
