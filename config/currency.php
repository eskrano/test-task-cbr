<?php

return [
    'default_provider' => env('CURRENCY_DEFAULT_PROVIDER', 'cbr'),
    'providers' => [
        'cbr' => \App\Services\CurrencyService\DataProviders\CBR::class,
        'test' => \App\Services\CurrencyService\DataProviders\TestProvider::class,
    ],
    'config' => [
        'cbr' => [
            'source_url' => 'https://www.cbr.ru/scripts/XML_daily.asp',
            'base_currency' => 'RUB',
        ],
        'test' => [
            'config_variable_test' => 'test_value'
        ],
    ],
];
