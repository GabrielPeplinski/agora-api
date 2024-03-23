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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Updating application!');
        $this->info('Updating permissions and roles...');

        Artisan::call('db:seed',
            ['--class' => 'UpdateSeeder']
        );

        $this->info('Permissions and roles updated!');
    }
}
