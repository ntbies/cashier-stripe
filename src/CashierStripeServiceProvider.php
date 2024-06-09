<?php

namespace Ntbies\CashierStripe;

use Illuminate\Support\ServiceProvider;
class CashierStripeServiceProvider extends ServiceProvider
{
    public function boot(){
        
        if($this->app->runningInConsole()){
            $publishesMigrationsMethod = method_exists($this, 'publishesMigrations')
                ? 'publishesMigrations'
                : 'publishes';
            
            $this->{$publishesMigrationsMethod}([
                __DIR__.'/../database/migrations' => $this->app->databasePath('migrations'),
            ], 'ntbies-cashier-migrations');
        }
        
    }
}