<?php

namespace suseche\walletstripe\Console;

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
        Artisan::call('migrate', array('--path' => 'app/migrations'));
    }
}
