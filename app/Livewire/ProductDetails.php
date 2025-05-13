<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductDetails extends Component
{
    use WithFileUploads;

    public $product;
    public $quantity = 1;
    public $referenceNo;
    public $showModal = false;
    public $amount;
    public $paymentMethod = 'OVER_THE_COUNTER';
    public $terms = false;
    public $image;

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);
        $this->amount = $this->product->price * $this->quantity;
    }

    public function showCheckoutModal()
    {
        if (!Auth::check()) {
            session()->flash('info', 'You must be logged in to proceed to checkout.');
            return redirect()->route('login');
        }

        $this->showModal = true;
    }

    public function addToCart()
    {
        $cart = session()->get('cart', []);
        $cart[$this->product->id] = ($cart[$this->product->id] ?? 0) + 1;
        session()->put('cart', $cart);

        session()->flash('message', 'Product added to cart!');
    }
    public function updatedQuantity($value)
    {
        $this->quantity = max(1, (int)$value); // Prevents zero or negative values
        $this->amount = $this->product->price * $this->quantity;
    }

    public function submitCheckout()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to complete the checkout process.');
            return;  // Stop further execution
        }

        $isPreorder = $this->product->stock_quantity <= 0 && $this->product->allows_preorder;

        if (!$isPreorder && $this->quantity > $this->product->stock_quantity) {
            session()->flash('error', 'Quantity exceeds available stock.');
            return;
        }

        // Validate input
        $rules = [
            'quantity' => ['required', 'integer', 'min:1'],
            'paymentMethod' => 'required',
            'terms' => 'accepted',
        ];

        if (!$isPreorder) {
            $rules['quantity'][] = 'max:' . $this->product->stock_quantity;
        }

        if ($this->paymentMethod === 'GCASH') {
            $rules['referenceNo'] = 'required|string';
            $rules['image'] = 'required|image|max:2048';
        }

        $this->validate($rules);
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
            'price' => $this->product->price * $this->quantity,
        ]);

        $imagePath = null;
        if ($this->paymentMethod === 'GCASH' && $this->image) {
            $imagePath = $this->image->store('payments', 'public');
        }

        Payment::create([
            'type' => 'orders',
            'type_id' => $order->id,
            'amount' => $this->amount,
            'payment_method' => $this->paymentMethod,
            'image' => $imagePath,
            'reference_no' => $this->referenceNo,
            'status' => 'PENDING',
        ]);

        // Only reduce stock if it's not a preorder
        if (!$isPreorder) {
            $this->product->stock_quantity -= $this->quantity;
            $this->product->save();
        }

        $this->reset(['quantity', 'paymentMethod', 'referenceNo', 'showModal', 'terms']);

        $this->amount = $this->product->price * $this->quantity;
        session()->flash('message', 'Order placed successfully!');
    }

    public function render()
    {
        return view('livewire.product-details');
    }
}
