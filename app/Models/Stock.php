<?php

namespace App\Models;

use App\Notifications\ImportantUpdateProduct;
use App\UseCases\TrackStock;
use Facades\App\Retail\RetailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Feature\TrackCommandTest;

class Stock extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function track()
    {
        TrackStock::dispatch($this);
//        dispatch(new TrackStock($this));
//        (new TrackStock($this))->handle();
    }

    public function retail()
    {
        return $this->belongsTo(Retail::class);
    }
}
