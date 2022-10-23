<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Retail\StockResponse;
use Database\Seeders\RetailWithProductSeeder;
use Facades\App\Retail\RetailFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_track_product_stock()
    {
        $this->seed(RetailWithProductSeeder::class);

        $product = Product::first();

        $this->assertFalse($product->inStock());

        RetailFactory::shouldReceive('getRetailByName->getUpdatedDataStock')->andReturn(
            new StockResponse(20000,true)
        );

        $this->artisan('stock:track')->expectsOutput('Done');

        $this->assertTrue($product->inStock());
    }
}
