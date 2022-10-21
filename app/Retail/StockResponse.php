<?php

namespace App\Retail;

class StockResponse
{
    public function __construct(public int $price, public bool $inStock)
    {
    }
}
