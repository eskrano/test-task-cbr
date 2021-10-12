<?php

namespace Tests\Unit;

use App\Services\CurrencyService\CurrencyServiceContract;
use App\Services\CurrencyService\DTO\Currency;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;

class CurrencyServiceTest extends TestCase
{
    use CreatesApplication;

    /**
     *
     */
    public function test_data_provider_return_correct_dtos()
    {
        /**
         * @var $service CurrencyServiceContract
         */
        $this->createApplication();
        $service = app(CurrencyServiceContract::class);
        $currencies = $service->getCurrencies();

        $this->assertTrue(count($currencies->toArray()) === 2);

        foreach ($service->getCurrencies()->toArray() as $currency) {
            $this->assertTrue(
                $currency instanceof Currency
            );
            $this->assertTrue($currency->getValue() !== null);
        }
    }
}
