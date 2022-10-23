<?php

namespace App\Models;

use Facades\App\Retail\RetailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public function track(callable $callback = null)
    {
        $stockResponse = RetailFactory::getRetailByName($this->retail->name)->getUpdatedDataStock($this);
        $this->update([
            'in_stock' => $stockResponse->inStock,
            'price' => $stockResponse->price
        ]);

        $callback && is_callable($callback) && $callback($this);
    }

    public function retail()
    {
        return $this->belongsTo(Retail::class);
    }
}
