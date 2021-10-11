<?php

namespace App\Services\ConvertService;

interface ConvertServiceContract
{

    /**
     * @param float $source_rate
     * @param float $destination_rate
     * @return float
     */
    public function convert(
        float $source_rate,
        float $destination_rate
    ): float;

    /**
     * @param float $source_rate
     * @param int $currency_id
     * @param int $nominal
     * @param int|null $date
     * @return float
     */
    public function convertById(float $source_rate, int $currency_id, int $nominal, int $date = null): float;
}
