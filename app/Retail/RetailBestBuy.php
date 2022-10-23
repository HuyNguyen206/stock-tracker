<?php

namespace App\Retail;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class RetailBestBuy implements RetailInterface
{
    public function getUpdatedDataStock(Stock $stock): StockResponse
    {
        $key = config('services.bestbuy.key');
        $result = Http::get("https://api.bestbuy.com/v1/products/{$stock->sku}.json?apiKey=$key")->json();

        return new StockResponse($this->dollarToCent($result['regularPrice']), $result['onlineAvailability']);
    }

    /**
     * @param $regularPrice
     * @return float|int
     */
    private function dollarToCent($regularPrice): int|float
    {
        return (int) ($regularPrice * 100);
    }
}
