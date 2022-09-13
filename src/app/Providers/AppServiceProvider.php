<?php

namespace App\Providers;

use App\Exceptions\ClamavLostConnectionException;
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
            $url = config('filesystems.securities.clamav.host');
            $port = config('filesystems.securities.clamav.port');

            $scanner = ScannerFactory::create([
                'driver' => 'remote',
                'remote' => [
                    'url' => $url,
                    'port' => $port,
                ]
            ]);
            try {
                $scanner->ping();
                Log::info("Connected to ClamAV");
                return $scanner;
            } catch (\RuntimeException $e) {
                throw new ClamavLostConnectionException($e->getMessage(), $url, $port);
            }
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
