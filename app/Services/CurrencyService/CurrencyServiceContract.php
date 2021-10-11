<?php

namespace App\Services\CurrencyService;

use App\Services\CurrencyService\DTO\Currencies;

interface CurrencyServiceContract
{
    /**
     * @return Currencies
     */
    public function getCurrencies(): Currencies;
}
