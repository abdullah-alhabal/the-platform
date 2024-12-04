<?php

declare(strict_types=1);

namespace App\Services\ThirdParty;

use Illuminate\Support\Facades\Http;

final class CurrencyExchangeService
{
    private string $apiUrl;

    private string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.currency_exchange.api_url');
        $this->apiKey = config('services.currency_exchange.api_key');
    }

    /**
     * Fetch the exchange rate between two currencies.
     */
    public function getExchangeRate(string $baseCurrency, string $targetCurrency): ?float
    {
        return cache()->remember("exchange_rate_{$baseCurrency}_{$targetCurrency}", now()->addHours(1), function () use ($baseCurrency, $targetCurrency) {
            $response = Http::get("{$this->apiUrl}/{$baseCurrency}", [
                'access_key' => $this->apiKey,
            ]);

            return $response->successful() && isset($response['rates'][$targetCurrency])
                ? (float) $response['rates'][$targetCurrency]
                : null;
        });
    }

    public function convertPrice(float $amount, string $fromCurrency, string $toCurrency): ?float
    {
        $exchangeRate = $this->getExchangeRate(
            baseCurrency: $fromCurrency,
            targetCurrency: $toCurrency,
        );

        return $exchangeRate ? $amount * $exchangeRate : null;
    }
}
