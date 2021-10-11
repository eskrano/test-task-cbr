<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

class CurrencyHistoryQuery
{
    public function handle(Builder $builder)
    {
        return $builder;
    }
}
