<?php

namespace Tests;

use App\Retail\StockResponse;
use Facades\App\Retail\RetailFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return void
     */
    public function mockRetailRequest($price = 299.99, $inStock = true): void
    {
        RetailFactory::shouldReceive('getRetailByName->getUpdatedDataStock')->andReturn(
            new StockResponse($price * 100, $inStock)
        );
    }
}
