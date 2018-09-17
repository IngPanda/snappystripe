<?php

namespace DataLive\snappyStripe\console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snappystripe:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the commands necessary to prepare Snappy Stripe for use';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->loadMigrationsFrom(__DIR__ . 'vendor/DataLive/snappyStripe/database/');
        Artisan::call('migrate', array('--path' => 'app/migrations'));
    }
}
