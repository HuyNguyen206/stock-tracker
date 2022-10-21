<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retail;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class RetailWithProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ps4 = Product::create(['name' => 'Play station']);
        $bestBuy = Retail::create(['name' => 'Amazon']);

        $bestBuy->addStock(new Stock([
            'price' => 10000,
            'url' => 'http://test.com',
            'sku' => '123456',
            'in_stock' => false
        ]),$ps4);
    }
}
