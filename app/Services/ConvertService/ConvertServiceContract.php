<?php

namespace App\Services\ConvertService;

interface ConvertServiceContract
{
    public function convert(
        float $source_rate,
        float $destination_rate
    ): float;
}
