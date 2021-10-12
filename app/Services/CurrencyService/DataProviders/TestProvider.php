<?php

namespace App\Services\CurrencyService\DataProviders;

use App\Services\CurrencyService\CurrencyServiceDataProviderContract;
use App\Services\CurrencyService\DTO\Currencies;
use App\Services\CurrencyService\DTO\Currency;
use App\Services\CurrencyService\Traits\ConfigurableDataProvider;

class TestProvider implements CurrencyServiceDataProviderContract
{
    use ConfigurableDataProvider;

    /**
     * @var string
     */
    protected string $config_variable_test;

    /**
     * @return Currencies|null
     */
    public function fetchData(): ?Currencies
    {
        return (new Currencies())
            ->addCurrency(
                (new  Currency())
                    ->setNumCode("001")
                    ->setNominal(1)
                    ->setValue(1.0)
                    ->setName("US Dollar")
                    ->setCharCode('USD')
            )
            ->addCurrency(
                (new Currency())
                    ->setNumCode('002')
                    ->setNominal(1)
                    ->setValue(1.01)
                    ->setName('EUR')
                    ->setCharCode('EUR')
            );
    }
}
