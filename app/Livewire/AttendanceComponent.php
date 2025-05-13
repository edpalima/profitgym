<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AttendanceComponent extends Component
{
    public $currentDate;
    public $showOrderModal = false;
    public $selectedUserId;
    public $selectedProducts = [];
    public $quantities = [];
    public $totalAmount = 0.00;
    public $paymentAmount = 0.00;
    public $changeAmount = 0.00;

    public function mount()
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, ['ADMIN', 'STAFF'])) {
            return redirect()->route('account');
        }

        $this->currentDate = Carbon::today()->toDateString();
    }

    public function previousDate()
    {
        $this->currentDate = Carbon::parse($this->currentDate)->subDay()->toDateString();
    }

    public function nextDate()
    {
        $this->currentDate = Carbon::parse($this->currentDate)->addDay()->toDateString();
    }

    public function timeIn($userId)
    {
        Attendance::firstOrCreate(
            ['user_id' => $userId, 'date' => $this->currentDate],
            [
                'date' => $this->currentDate,
                'time_in' => now()
            ]
        );
    }

    public function timeOut($userId)
    {
        $attendance = Attendance::firstOrCreate(
            ['user_id' => $userId, 'date' => $this->currentDate],
            ['time_in' => null]
        );

        if (!$attendance->time_out) {
            $attendance->update(['time_out' => now()]);
        }
    }

    public function render()
    {
        $users = User::where('role', 'MEMBER')
            ->with(['memberships' => function ($query) {
                // Use the activeForDate scope to filter memberships for the current date
                $query->activeForDate($this->currentDate);
            }])
            ->whereHas('memberships', function ($query) {
                $query->activeForDate($this->currentDate);
            })
            ->get();

        $attendances = Attendance::where('date', $this->currentDate)->get()->keyBy('user_id');

        $this->totalAmount = 0;

        foreach ($this->selectedProducts as $productId) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $quantity = max(1, (int) ($this->quantities[$productId] ?? 1));
                $this->totalAmount += $product->price * $quantity;
            }
        }

        return view('livewire.attendance-component', [
            'users' => $users,
            'attendances' => $attendances,
            'currentDate' => $this->currentDate,
        ])->layout('layouts.attendance'); // Make sure this layout file exists
    }

    public function updatedSelectedProducts()
    {
        foreach ($this->selectedProducts as $productId) {
            if (!isset($this->quantities[$productId]) || $this->quantities[$productId] < 1) {
                $this->quantities[$productId] = 1;
            }
        }

        // Clean up quantities of unselected products (optional but recommended)
        foreach ($this->quantities as $productId => $quantity) {
            if (!in_array($productId, $this->selectedProducts)) {
                unset($this->quantities[$productId]);
            }
        }
    }

    public function updatedPaymentAmount()
    {
        $this->calculateChange();
    }

    public function calculateChange()
    {
        $this->changeAmount = max(0, (float) $this->paymentAmount - (float) $this->totalAmount);
    }

    public function createOrder($userId)
    {
        $this->selectedUserId = $userId;
        $this->selectedProducts = [];
        $this->quantities = [];
        $this->showOrderModal = true;
    }

    public function submitOrder()
    {
        $this->validate([
            'selectedProducts' => 'required|array|min:1',
            'paymentAmount' => 'required|numeric|min:' . $this->totalAmount,
        ]);

        $order = \App\Models\Order::create([
            'user_id' => $this->selectedUserId,
            'total_amount' => 0,
            'status' => 'COMPLETED',
        ]);

        $total = 0;

        foreach ($this->selectedProducts as $productId) {
            $product = Product::find($productId);
            $quantity = max(1, (int) ($this->quantities[$productId] ?? 1));

            if ($product && $product->stock_quantity >= $quantity) {
                // Create order item
                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                // Subtract stock
                $product->stock_quantity -= $quantity;
                $product->save();

                $total += $product->price * $quantity;
            }
        }

        $order->update(['total_amount' => $total]);

        Payment::create([
            'type' => 'orders',
            'type_id' => $order->id,
            'amount' => $total,
            'payment_method' => 'OVER_THE_COUNTER',
            'status' => 'CONFIRMED',
        ]);

        $this->showOrderModal = false;
        $this->selectedProducts = [];
        $this->selectedUserId = null;
        $this->paymentAmount = 0.00;
        $this->quantities = [];

        session()->flash('message', 'Order created successfully.');
    }
}
