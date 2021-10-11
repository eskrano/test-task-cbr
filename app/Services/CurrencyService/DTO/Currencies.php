<?php

namespace App\Services\CurrencyService\DTO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Currencies implements Arrayable
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

    /**
     * @return Currency[]
     */
    public function toArray(): array
    {
        return $this->getCurrencies();
    }

    /**
     * @param string $char_code
     * @return mixed
     */
    public function findCurrencyByCharCode(string $char_code)
    {
        return collect($this->getCurrencies())->where('char_code', $char_code)->first();
    }
}
