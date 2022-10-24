<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Retail;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $retail = Retail::factory()->create(['name' => 'BestBuy']);
        $products = Product::factory(2)->create();
        foreach ($products as $product)
        {
            $product->stocks()->createMany(Stock::factory(2)->raw([
                'retail_id' => $retail->id
            ]));
        }
    }
}
