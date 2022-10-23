<?php

namespace Tests\Retails;

use App\Models\Product;
use App\Models\Stock;
use App\Retail\RetailBestBuy;
use App\Retail\StockResponse;
use Database\Seeders\RetailWithProductSeeder;
use Facades\App\Retail\RetailFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class BestBuyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * @group real_api
     * @return void
     */
    public function test_it_track_product_via_real_endpoint()
    {
        $this->seed(RetailWithProductSeeder::class);

        $stock = tap(Stock::first())->update([
            'sku' => '6426149',
            'url' => 'https://www.bestbuy.com/site/sony-playstation-5-console/6426149.p?skuId=6426149',
        ]);
        try {
            $result = app(RetailBestBuy::class)->getUpdatedDataStock($stock);
        }catch (\Exception $exception)
        {
            Log::error($message = $exception->getMessage());
            $this->fail("Can't track the stock for BestBuy retailer due to '$message'");
        }

        $this->assertInstanceOf(StockResponse::class, $result);
    }

    public function test_create_the_proper_stock_status_response()
    {
        $this->seed(RetailWithProductSeeder::class);

        Http::fake(fn() => [
            'onlineAvailability' => true,
            'regularPrice' => 299.99
        ]);

        Stock::first()->track();

        $this->assertDatabaseHas('stocks', [
            'price' => 29999
        ]);

    }
}
