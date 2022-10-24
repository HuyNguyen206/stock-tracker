<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->output->progressStart(Product::count());
        Product::chunk(10, function ($products) {
            $products->each(function ($product) {
                $this->output->progressAdvance();
                $product->track();
            });
        });
        $this->output->progressFinish();

        $productStocks = Product::query()
            ->select(['name', 'price', 'in_stock', 'url'])
            ->leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
            ->get();

        $this->table(['name', 'price', 'in_stock', 'url'], $productStocks);
        $this->info('Done');

        return Command::SUCCESS;
    }
}
