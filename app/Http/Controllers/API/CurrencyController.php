<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyHistoryCollection;
use App\Models\Currency;
use App\Http\Resources\CurrencyCollection;
use App\Models\CurrencyDayData;
use App\Queries\CurrencyHistoryQuery;
use App\Queries\CurrencyQuery;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\Request;
use \App\Http\Resources\Currency as CurrencyResource;

class CurrencyController extends Controller
{

    /**
     * @param Request $request
     * @return CurrencyCollection
     */
    public function all(Request $request): CurrencyCollection
    {
        return CurrencyCollection::make(
            app(Pipeline::class)
                ->send(Currency::query())
                ->through([
                    CurrencyQuery::class,
                ])
                ->thenReturn()
                ->paginate(
                    $request->get('page_size', 10)
                )
        );
    }

    public function show(Currency $currency): \App\Http\Resources\Currency
    {
        return CurrencyResource::make(
            app(Pipeline::class)
                ->send(Currency::query())
                ->through([
                    CurrencyQuery::class,
                ])
                ->thenReturn()
                ->first()
        );
    }

    /**
     * @param Currency $currency
     * @param Request $request
     * @return CurrencyHistoryCollection
     */
    public function history(Currency $currency, Request $request): CurrencyHistoryCollection
    {
        return CurrencyHistoryCollection::make(
            app(Pipeline::class)
                ->send($currency->dayData()->getQuery())
                ->through([
                    CurrencyHistoryQuery::class,
                ])
                ->thenReturn()
                ->paginate(
                    $request->get('page_size', 10)
                )
        );
    }
}
