<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Passport::loadKeysFrom(__DIR__.'/../secrets/oauth'); // ask 

        Passport::loadKeysFrom(
            env('PASSPORT_PUBLIC_KEY'),
            env('PASSPORT_PRIVATE_KEY')
        );

        //
        Passport::tokensExpireIn(CarbonInterval::days(15));
        Passport::refreshTokensExpireIn(CarbonInterval::days(30));
        Passport::personalAccessTokensExpireIn(CarbonInterval::months(6));
    }
}
