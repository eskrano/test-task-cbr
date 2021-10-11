<?php

namespace App\Queries;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class CurrencyHistoryQuery
{
    public function handle(Builder $builder): Builder
    {
        if (request()->has('date_from')) {
            $builder->where('sync_date', '>=',
                Carbon::createFromFormat('Y-m-d', request()->get('date_from'))->format('Y-m-d'));

            if (request()->has('date_to')) {
                $to = Carbon::createFromFormat('Y-m-d', request()->get('date_to'))->format('Y-m-d');
            } else {
                $to = now()->format('Y-m-d');
            }

            $builder->where('sync_date', '<=', $to);
        }

        return $builder;
    }
}
