<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class Products extends Component
{
    public function render()
    {
        // Get all active products
        $products = Product::where('is_active', true)->get();

        // Pass the active products to the view
        return view('livewire.products', compact('products'));
    }
}
