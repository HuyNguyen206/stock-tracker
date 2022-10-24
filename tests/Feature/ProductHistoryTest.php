<?php

namespace Tests\Feature;

use App\Models\History;
use App\Models\Product;
use App\Models\Stock;
use App\Retail\RetailBestBuy;
use App\Retail\StockResponse;
use Database\Seeders\RetailWithProductSeeder;
use Facades\App\Retail\RetailFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_record_history_each_time_stock_is_tracked()
    {
        $this->seed(RetailWithProductSeeder::class);
        $product = Product::first();
        $this->assertCount(0, $product->histories);
//        Http::fake(fn() => [
//            'onlineAvailability' => true,
//            'regularPrice' => 299.99
//        ]);
//
//        RetailFactory::shouldReceive('getRetailByName->getUpdatedDataStock')->andReturn(
//            new StockResponse(29999, true)
//        );
        $this->mockRetailRequest();
        $product->track();

        $this->assertCount(1, $product->fresh()->histories);
        $firstHistory = $product->histories()->first();
        $stock = $product->stocks()->first();
        $this->assertEquals($stock->price, $firstHistory->price);
        $this->assertEquals($stock->product_id, $firstHistory->product_id);
        $this->assertEquals($stock->id, $firstHistory->stock_id);
    }
}
