<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class OtherProducts extends Component
{
    public $currentProductId;

    public function render()
    {
        $products = Product::where('is_active', true)
            ->where('id', '!=', $this->currentProductId)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('livewire.other-products', [
            'products' => $products,
        ]);
    }
}