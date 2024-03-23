<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update application permissions and roles.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Updating application!');

        $this->updatePermissionsAndRoles();
    }

    private function updatePermissionsAndRoles(): void
    {
        $this->info('Updating permissions...');
        Artisan::call('db:seed',
            ['--class' => 'PermissionSeeder']
        );

        $this->info('Updating roles...');
        Artisan::call('db:seed',
            ['--class' => 'RoleSeeder']
        );

        $this->info('Permissions and roles updated!');
    }
}
