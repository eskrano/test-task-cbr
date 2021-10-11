<?php

namespace App\Console\Commands;

use App\Services\CurrencyService\CurrencyServiceContract;
use Illuminate\Console\Command;

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



        return 0;
    }
}
