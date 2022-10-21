<?php

namespace App\Models;

use App\Retail\RetailFactory;
use App\Retail\RetailInterface;
use App\RetailNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Retail extends Model
{
    use HasFactory;

    public function addStock(Stock $stock, Product $product)
    {
        $stock->product_id = $product->id;
        $this->stocks()->save($stock);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
