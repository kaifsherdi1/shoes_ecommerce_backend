<?php
namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    public function created(Product $product) {
        // Example: log for now; in real app sync search index
        Log::info("Product created: {$product->id}");
    }

    public function updated(Product $product) {
        Log::info("Product updated: {$product->id}");
    }

    public function deleted(Product $product) {
        Log::info("Product deleted: {$product->id}");
    }
}
