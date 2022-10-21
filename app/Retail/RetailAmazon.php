<?php

namespace App\Retail;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class RetailAmazon implements RetailInterface
{
    public function getUpdatedDataStock(Stock $stock): StockResponse
    {
       $result = Http::get('http://foo.net')->json();

       return new StockResponse($result['price'], $result['available']);
    }
}
