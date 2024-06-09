<?php

namespace Ntbies\CashierStripe;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Cashier;
use Ntbies\CashierStripe\Listeners\WebhookProcessor;
use Laravel\Cashier\Events\WebhookReceived;

class CashierStripeServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->registerRoutes();
        if($this->app->runningInConsole()){
            $publishesMigrationsMethod = method_exists($this, 'publishesMigrations')
                ? 'publishesMigrations'
                : 'publishes';

            $this->{$publishesMigrationsMethod}([
                __DIR__.'/../database/migrations' => $this->app->databasePath('migrations'),
            ], 'ntbies-cashier-migrations');
        }
        $this->registerListeners();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
    }

    /**
     * Merge the configuration to cashier.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/cashier.php', 'cashier'
        );
    }
    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if (Cashier::$registersRoutes) {
            Route::group([
                'prefix' => config('cashier.path'),
                'namespace' => 'Ntbies\CashierStripe\Http\Controllers',
                'as' => 'cashier.',
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            });
        }
    }

    /**
     * Configure the Spark event listeners.
     *
     * @return void
     */
    protected function registerListeners()
    {
        $this->app['events']->listen(
            WebhookReceived::class,
            [WebhookProcessor::class, 'handle']
        );
    }
}
