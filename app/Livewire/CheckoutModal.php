<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutModal extends Component
{
    public $product;
    public $quantity = 1;
    public $paymentMethod;
    public $referenceNo;
    public $showModal = false;

    protected $listeners = ['openCheckoutModal' => 'openModal'];

    public function openModal($productId)
    {
        $this->product = Product::findOrFail($productId);
        $this->showModal = true;
    }

    public function submit()
    {
        $total = $this->product->price * $this->quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'PENDING',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'quantity' => $this->quantity,
            'price' => $this->product->price,
        ]);

        Payment::create([
            'type' => 'products',
            'type_id' => $order->id,
            'amount' => $total,
            'payment_method' => $this->paymentMethod,
            'reference_no' => $this->referenceNo,
            'status' => 'PENDING',
        ]);

        $this->reset(['showModal', 'quantity', 'paymentMethod', 'referenceNo']);
        session()->flash('message', 'Order placed successfully!');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.checkout-modal');
    }
}
