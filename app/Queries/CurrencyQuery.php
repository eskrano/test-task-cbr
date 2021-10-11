<?php

namespace App\Queries;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CurrencyQuery
{
    public function handle(Builder $builder): Builder
    {
        $builder->with([
            'dayData' => function (HasMany $query) {
                $query->where('sync_date',
                    Carbon::createFromFormat(
                        'Y-m-d',
                        request()->get('date', now()->format('Y-m-d'))
                    )->format('Y-m-d'));
            }
        ])->withAvg('dayData', 'rate')
            ->withMax('dayData', 'rate')
            ->withMin('dayData', 'rate');

        return $builder;
    }
}
