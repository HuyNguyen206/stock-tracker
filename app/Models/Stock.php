<?php

namespace App\Models;

use Facades\App\Retail\RetailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public function track()
    {
        $stockResponse = RetailFactory::getRetailByName($this->retail->name)->getUpdatedDataStock($this);

        $this->update([
            'in_stock' => $stockResponse->inStock,
            'price' => $stockResponse->price
        ]);
    }

    public function retail()
    {
        return $this->belongsTo(Retail::class);
    }
}
