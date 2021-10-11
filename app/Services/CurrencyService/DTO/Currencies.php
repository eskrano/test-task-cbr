<?php

namespace App\Services\CurrencyService\DTO;

use Illuminate\Support\Collection;

class Currencies
{
    /**
     * @var Currency[]
     */
    protected array $currencies;

    /**
     * @return Currency[]
     */
    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    /**
     * @param Currency $currency
     * @return $this
     */
    public function addCurrency(Currency $currency): Currencies
    {
        $this->currencies[] = $currency;

        return $this;
    }
}
