<?php

namespace App\Console\Commands;

use App\Mail\LowStockMail;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LowStockAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:low-stock-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email alerts for products that are low in stock';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = 2;
        $lowStockProducts = Product::where('stock', '<=', $threshold)->get();

        if ($lowStockProducts->isNotEmpty()) {
            $adminEmail = "admin@gmail.com";

            Mail::to($adminEmail)->send(new LowStockMail($lowStockProducts));

            $this->info("Low stock alert email sent to admin.");
        } else {
            $this->info("No products are low in stock.");
        }
    }
}
