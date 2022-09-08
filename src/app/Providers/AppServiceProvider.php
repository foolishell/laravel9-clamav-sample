<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Niisan\ClamAV\ScannerFactory;
use Illuminate\Support\ServiceProvider;
use Niisan\ClamAV\Scanner;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * @return void
     */
    public function register()
    {
        // ClamAV　クライアントを DI コンテナに登録
        $this->app->singleton(Scanner::class, function ($app) {
            $scanner = ScannerFactory::create([
                'driver' => 'remote',
                'remote' => [
                    'url' => config('filesystems.securities.clamav.host'),
                    'port' => config('filesystems.securities.clamav.port'),
                ]
            ]);
            if ($scanner->ping()) Log::info("Connected to ClamAV");
            return $scanner;
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
