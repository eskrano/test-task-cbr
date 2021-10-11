<?php

namespace App\Services\CurrencyService;


use App\Services\CurrencyService\DTO\Currencies;
use App\Services\CurrencyService\Exception\NoDataReachedException;

class CurrencyService implements CurrencyServiceContract
{
    /**
     * @var CurrencyServiceDataProviderContract|null
     */
    protected CurrencyServiceDataProviderContract $data_provider;

    /**
     * @param CurrencyServiceDataProviderContract $data_provider
     */
    public function __construct(CurrencyServiceDataProviderContract $data_provider)
    {
        $this->data_provider = $data_provider;
    }

    /**
     * @return Currencies
     * @throws NoDataReachedException
     */
    public function getCurrencies(): Currencies
    {
        $result = $this->data_provider->fetchData();

        if (null !== $result) {
            return $result;
        }

        throw new NoDataReachedException();
    }

    public function changeDataProvider(CurrencyServiceDataProviderContract $new_data_provider): void
    {
        $this->data_provider = $new_data_provider;
    }


}
