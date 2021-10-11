<?php

namespace App\Queries;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class CurrencyQuery
{
    public function handle(Builder $builder): Builder
    {
        $builder->with([
            'dayData' => function ($query) {
                $query->where('sync_date',
                    Carbon::createFromFormat(
                        'Y-m-d',
                        request()->get('date', now()->format('Y-m-d'))
                    )->format('Y-m-d'));
            }
        ]);

        return $builder;
    }
}
