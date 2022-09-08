<?php

namespace App\Providers;

use Appwrite\ClamAV\Network;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Network::class, function ($app) {
            return new Network(
                host: config('filesystems.securities.clamav.host'),
                port: config('filesystems.securities.clamav.port'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
