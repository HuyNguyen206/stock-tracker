<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    /**
     * @return void
     */
    public function recordHistory(Stock $stock): void
    {
        $this->histories()->create([
            'price' => $stock->price,
            'in_stock' => $stock->in_stock,
            'stock_id' => $stock->id
        ]);
    }

    public function track()
    {
        $this->stocks()->chunk(10, function ($stocks) {
//            $stocks->each(function ($stock) {
//                $stock->track();
//                $this->recordHistory($stock);
//            });
            $stocks->each->track(fn($stock) => $this->recordHistory($stock));
        });
    }

    public function inStock()
    {
        return $this->stocks()->where('in_stock', true)->exists();
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
