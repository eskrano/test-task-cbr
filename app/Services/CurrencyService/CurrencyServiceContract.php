<?php

namespace App\Services\CurrencyService;

use App\Services\CurrencyService\DTO\Currencies;

interface CurrencyServiceContract
{
    /**
     * @return Currencies
     */
    public function getCurrencies(): Currencies;

    /**
     * @param CurrencyServiceDataProviderContract $new_data_provider
     */
    public function changeDataProvider(CurrencyServiceDataProviderContract $new_data_provider): void;
}
