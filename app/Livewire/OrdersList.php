<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrdersList extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return view('livewire.orders-list', compact('orders'));
    }
}
