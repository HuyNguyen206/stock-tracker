<?php

namespace App\Retail;

use App\Models\Stock;

interface RetailInterface
{
    public function getUpdatedDataStock(Stock $stock): StockResponse;
}
