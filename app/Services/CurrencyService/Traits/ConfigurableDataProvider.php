<?php

namespace App\Services\CurrencyService\Traits;

trait ConfigurableDataProvider
{
    public function configure(array $config): void
    {
        if (0 === count($config)) {
            return;
        }

        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
