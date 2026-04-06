<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Http\HttpClientOptions;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Factory::class, function () {
            $options = HttpClientOptions::default()
                ->withGuzzleConfigOptions([
                    'verify' => 'C:/php/cacert.pem',
                ]);

            return (new Factory())
                ->withServiceAccount(env('FIREBASE_CREDENTIALS'))
                ->withHttpClientOptions($options);
        });
    }

    public function boot(): void
    {
        //
    }
}
