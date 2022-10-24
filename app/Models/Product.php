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

    public function track()
    {
        $this->stocks()->chunk(10, function ($stocks) {
//            $stocks->each(function ($stock) {
//                $stock->track();
//                $this->recordHistory($stock);
//            });
            $stocks->each->track();
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
