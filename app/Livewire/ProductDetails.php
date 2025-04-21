<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductDetails extends Component
{
    public $product;

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);
    }

    public function addToCart()
    {
        $cart = session()->get('cart', []);
        $cart[$this->product->id] = ($cart[$this->product->id] ?? 0) + 1;
        session()->put('cart', $cart);

        session()->flash('message', 'Product added to cart!');
    }

    public function render()
    {
        return view('livewire.product-details');
    }
}
