<?php

namespace App\Console\Commands;

use App\Domains\Account\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Console\Command;

class UpgradeRolesAndPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade-roles-and-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade API roles and permissions according to RolesAndPermissions class.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Running RolesAndPermissionsSeeder...');
        $this->call(RolesAndPermissionsSeeder::class);
        $this->info('RolesAndPermissionsSeeder completed!');

        User::all()->each(function (User $user) {
            $user->assignRole('client');
        });
    }
}
