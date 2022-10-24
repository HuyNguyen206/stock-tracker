<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Retail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'retail_id' => Retail::factory(),
            'price' => 10000,
            'in_stock' => false,
            'url' => 'https://foo.com',
            'sku' => '6426149'
        ];
    }
}
