<?php

namespace App\Providers;

use App\Services\ConvertService\ConvertService;
use App\Services\ConvertService\ConvertServiceContract;
use App\Services\CurrencyService\CurrencyService;
use App\Services\CurrencyService\CurrencyServiceContract;
use App\Services\CurrencyService\CurrencyServiceDataProviderContract;
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

        /**
         * Convert service register
         */

        $this->app->bind(ConvertServiceContract::class, ConvertService::class);

        /**
         * Register currency services
         */

        $this->app->bind(
            CurrencyServiceDataProviderContract::class,
            function ($app) {
                $dp_class = config('currency.providers')[config('currency.default_provider')] ?? null;

                if (null === $dp_class) {
                    throw new \InvalidArgumentException("Currency default provider not found.");
                }

                $dp_instance = new $dp_class();
                $dp_instance->configure(config('currency.config')[config('currency.default_provider')]);

                return $dp_instance;
            }
        );

        $this->app->bind(
            CurrencyServiceContract::class,
            function ($app) {
                return new CurrencyService($app->make(CurrencyServiceDataProviderContract::class));
            }
        );
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
