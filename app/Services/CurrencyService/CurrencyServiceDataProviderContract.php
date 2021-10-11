<?php

namespace App\Services\CurrencyService;

use App\Services\CurrencyService\DTO\Currencies;

interface CurrencyServiceDataProviderContract
{
    /**
     * @return Currencies|null
     */
    public function fetchData(): ?Currencies;

    /**
     * @param array $config
     */
    public function configure(array $config): void;
}
