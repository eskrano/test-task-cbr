<?php

namespace App\Console\Commands;

use App\Services\CurrencyService\CurrencyServiceContract;
use App\Services\CurrencyService\DTO\Currencies;
use App\Services\CurrencyService\DTO\Currency;
use Illuminate\Console\Command;
use App\Models\Currency as CurrencyModel;

class FetchCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch currencies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CurrencyServiceContract $currencyService): int
    {
        $currencies = $currencyService->getCurrencies();

        foreach ($currencies->toArray() as $currency) {
            try {
                $this->upsertCurrency($currency);
            } catch (\Exception $exception) {
                $this->error(sprintf("Exception when upsert currency %s", $exception->getMessage()));
            }
        }


        return 0;
    }

    protected function upsertCurrency(Currency $currency)
    {
        /**
         * @var $currency_db CurrencyModel
         */
        $currency_db = CurrencyModel::updateOrCreate([
            'code' => $currency->getCharCode(),
            'num_code' => $currency->getNumCode(),
            'name' => $currency->getName()
        ], ['code' => $currency->getCharCode()]);

        if (!$currency_db->dayData()->where('sync_date', now()->format('Y-m-d'))->exists()) {
            $currency_db->dayData()->create([
                'rate' => $currency->getValue(),
                'sync_date' => now(),
            ]);
        }
    }
}
