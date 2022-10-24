<?php

namespace App\UseCases;

use App\Models\History;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\ImportantUpdateProduct;
use Facades\App\Retail\RetailFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TrackStock implements ShouldQueue
{
    use Dispatchable;
    protected $stockResponse;
    public function __construct(protected Stock $stock)
    {
    }

    public function handle()
    {
        $this->checkAvalability();
        $this->notifyUser();
        $this->refreshStock();
        $this->recordHistory();
    }

    protected function checkAvalability() {
        $this->stockResponse =  RetailFactory::getRetailByName($this->stock->retail->name)->getUpdatedDataStock($this->stock);
    }

    protected function notifyUser()
    {
        if ($this->becomeAvailable()) {
            User::first()->notify(new ImportantUpdateProduct($this->stock));
        }
    }

    protected function refreshStock()
    {
        $this->stock->update([
            'in_stock' => $this->stockResponse->inStock,
            'price' => $this->stockResponse->price
        ]);
    }

    protected function recordHistory()
    {
       History::create([
            'price' => $this->stock->price,
            'in_stock' => $this->stock->in_stock,
            'stock_id' => $this->stock->id,
            'product_id' => $this->stock->product_id
        ]);
    }

    /**
     * @return bool
     */
    public function becomeAvailable(): bool
    {
        return !$this->stock->in_stock && $this->stockResponse->inStock;
    }

}
