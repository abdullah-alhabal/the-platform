<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ThirdParty\CurrencyExchangeService;
use Illuminate\Console\Command;

final class UpdateExchangeRates extends Command
{
    protected $signature = 'currency:update-exchange-rates';

    protected $description = 'Update cached exchange rates for all supported currencies';

    protected CurrencyExchangeService $currencyExchangeService;

    public function __construct(CurrencyExchangeService $currencyExchangeService)
    {
        parent::__construct();
        $this->currencyExchangeService = $currencyExchangeService;
    }

    public function handle(): void
    {
        $baseCurrency = 'EUR'; // Example
        $targetCurrencies = ['USD', 'SAR', 'AED', 'SYP']; // Add relevant currencies

        foreach ($targetCurrencies as $targetCurrency) {
            $this->currencyExchangeService->getExchangeRate($baseCurrency, $targetCurrency);
        }

        $this->info('Exchange rates updated successfully.');
    }
}
