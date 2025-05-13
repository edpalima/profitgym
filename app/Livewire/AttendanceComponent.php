<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceComponent extends Component
{
    public $currentDate;
    public $showOrderModal = false;
    public $selectedUserId;
    public $selectedProducts = [];

    public function mount()
    {
        $this->currentDate = Carbon::today()->toDateString(); // default to today
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
            ->with(['memberships' => function ($q) {
                $q->where('is_active', true)
                    ->where('status', 'APPROVED');
            }])
            ->whereHas('memberships', function ($query) {
                $today = now()->toDateString();
                $query->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            })
            ->get();

        $attendances = Attendance::where('date', $this->currentDate)->get()->keyBy('user_id');

        return view('livewire.attendance-component', [
            'users' => $users,
            'attendances' => $attendances,
            'currentDate' => $this->currentDate,
        ])->layout('layouts.attendance'); // Make sure this layout file exists
    }

    public function createOrder($userId)
    {
        $this->selectedUserId = $userId;
        $this->selectedProducts = [];
        $this->showOrderModal = true;
    }
    public function submitOrder()
    {
        $this->validate([
            'selectedProducts' => 'required|array|min:1',
        ]);

        $order = \App\Models\Order::create([
            'user_id' => $this->selectedUserId,
            'total_amount' => 0,
            'status' => 'pending',
        ]);

        $total = 0;
        foreach ($this->selectedProducts as $productId) {
            $product = Product::find($productId);
            if ($product) {
                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                ]);
                $total += $product->price;
            }
        }

        $order->update(['total_amount' => $total]);

        $this->showOrderModal = false;
        $this->selectedProducts = [];
        $this->selectedUserId = null;

        session()->flash('message', 'Order created successfully.');
    }
}
