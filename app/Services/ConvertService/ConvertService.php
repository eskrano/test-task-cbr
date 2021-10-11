<?php

namespace App\Services\ConvertService;

use App\Models\Currency;
use App\Models\CurrencyDayData;
use Illuminate\Support\Carbon;

class ConvertService implements ConvertServiceContract
{
    public function convert(float $source_rate, float $destination_rate): float
    {
        return round($source_rate / $destination_rate, 4);
    }

    /**
     * @param float $source_rate
     * @param int $currency_id
     * @param int $nominal
     * @param int|null $date
     * @return float
     */
    public function convertById(float $source_rate, int $currency_id, int $nominal, int $date = null): float
    {
        if (null === $date) {
            $date = now();
        } else {
            $date = Carbon::createFromTimestamp($date);
        }

        $rate_for_currency = CurrencyDayData::with([
            'currency' => function ($query) {
                $query->select(['id', 'nominal']);
            }
        ])->where('currency_id', $currency_id)
            ->first();

        if (null === $rate_for_currency) {
            throw new \InvalidArgumentException("No rate found for currency for given date");
        }

        return $this->convert($source_rate / $nominal, $rate_for_currency->rate / $rate_for_currency->currency->nominal);
    }


}
