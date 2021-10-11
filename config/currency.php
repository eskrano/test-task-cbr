<?php

return [
    'default_provider' => env('CURRENCY_DEFAULT_PROVIDER', 'cbr'),
    'providers' => [
        'cbr' => \App\Services\CurrencyService\DataProviders\CBR::class,
    ],
    'config' => [
        'cbr' => [
            'source_url' => 'https://www.cbr.ru/scripts/XML_daily.asp',
            'base_currency' => 'RUB',
        ],
    ],
];
