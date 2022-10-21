<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retail;
use App\Models\Stock;
use App\Retail\RetailInterface;
use App\Retail\StockResponse;
use Facades\App\Retail\RetailFactory;
use App\RetailNotFoundException;
use Database\Seeders\RetailWithProductSeeder;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Tests\FakeRetail;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_check_stock_for_product_at_retailer()
    {
       $this->seed(RetailWithProductSeeder::class);

       $product = Product::first();

       $this->assertFalse($product->inStock());
    }

    public function test_track_product_stock()
    {
        $this->seed(RetailWithProductSeeder::class);

        $product = Product::first();

        $this->assertFalse($product->inStock());

        Http::fake(function () {
            return [
                'available' => true,
                'price' => 20000
            ];
        });

        $this->artisan('stock:track')->expectsOutput('Done');

        $this->assertTrue($product->inStock());
    }

    public function test_it_throw_exception_if_a_retail_implementation_is_not_found_when_tracking()
    {
        $this->seed(RetailWithProductSeeder::class);

        Retail::first()->update(['name' => 'Non Exist Retail For Sure']);

        $this->expectException(RetailNotFoundException::class);

        Stock::first()->track();
    }

    public function test_it_update_stock_local_after_being_track()
    {
        $this->seed(RetailWithProductSeeder::class);

        $product = Product::first();

        $this->assertFalse($product->inStock());

//        $retailMock = \Mockery::mock(RetailInterface::class);
//        $retailMock->shouldReceive('getUpdatedDataStock')->andReturn(new StockResponse(20000,true));

        RetailFactory::shouldReceive('getRetailByName->getUpdatedDataStock')->andReturn(
            new StockResponse(20000,true)
        );

        $this->assertDatabaseMissing('stocks', [
            'price' => 20000,
            'in_stock' => true
        ]);

       Stock::first()->track();

        $this->assertDatabaseHas('stocks', [
            'price' => 20000,
            'in_stock' => true
        ]);
    }
}
