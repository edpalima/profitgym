<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductSection extends Component
{
    public function render()
    {
        // Get all active products
        $products = Product::where('is_active', true)->limit(3)->get();

        // Pass the active products to the view
        return view('livewire.products-section', compact('products'));
    }
}
