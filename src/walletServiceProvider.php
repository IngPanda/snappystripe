<?php 

namespace suseche\walletstripe;

use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider
{


/**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       

        if ($this->app->runningInConsole()) {
            $this->registerMigrations();

            /*$this->commands([
                Console\InstallCommand::class,
            ]);*/
        }
    }

        /**
     * Register Passport's migration files.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        
        return $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }


}