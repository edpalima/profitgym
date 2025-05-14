<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Membership;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\UserMembership;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AttendanceComponent extends Component
{
    public $currentDate;
    public $showOrderModal = false;
    public $selectedUserId;
    public $selectedUserFullName;
    public $selectedProducts = [];
    public $quantities = [];
    public $totalAmount = 0.00;
    public $paymentAmount = 0.00;
    public $changeAmount = 0.00;
    public $userModal = false;
    public $first_name;
    public $last_name;
    public $email;
    public $membership_id;
    public $start_date;
    public $end_date;
    public $total_amount = 0;
    public $payment_amount = 0;
    public $change_amount = 0;

    public $memberships;

    public function mount()
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, ['ADMIN', 'STAFF'])) {
            return redirect()->route('account');
        }

        $this->currentDate = Carbon::today()->toDateString();

        $this->memberships = Membership::where('is_active', true)->get();
    }

    public function previousDate()
    {
        $this->currentDate = Carbon::parse($this->currentDate)->subDay()->toDateString();
    }

    public function getMemberships()
    {
        return Membership::all(); // Adjust to your database query for memberships
    }

    public function updatedMembershipId()
    {
        $membership = Membership::find($this->membership_id);
        $this->total_amount = $membership ? $membership->price : 0;
        $this->calculateChange();
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
        // Fetch the users with active memberships for the current date
        $users = User::where('role', 'MEMBER')
            ->with(['memberships' => function ($query) {
                // Use the activeForDate scope to filter memberships for the current date
                $query->activeForDate($this->currentDate);
            }])
            ->whereHas('memberships', function ($query) {
                $query->activeForDate($this->currentDate);
            })
            ->get();

        // Get attendances for the current date
        $attendances = Attendance::where('date', $this->currentDate)->get()->keyBy('user_id');

        // Fetch orders for the current date
        $orders = Order::with('orderItems')
            ->whereIn('user_id', $users->pluck('id'))
            ->where('created_at', '>=', "{$this->currentDate} 00:00:00")
            ->where('created_at', '<=', "{$this->currentDate} 23:59:59")
            ->get()
            ->groupBy('user_id');

        // Calculate total amount based on selected products
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
            'orders' => $orders, // Pass orders to the view
        ])->layout('layouts.attendance');
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

        if ($this->total_amount) {
            $this->change_amount = max(0, (float) $this->payment_amount - (float) $this->total_amount);
        }
    }

    public function createOrder($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::find($userId);
        $this->selectedUserFullName = $user ? $user->fullName : null;
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

        $order = Order::create([
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

    public function showCreateUserModal()
    {
        $this->resetValidation();
        $this->userModal = true;
    }

    public function createNewUser()
    {
        $email = $this->first_name . '_' . $this->last_name . '@gmail.com';

        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email',
            'start_date' => 'required|date',
            'membership_id' => 'required|exists:memberships,id',
            'payment_amount' => 'required|numeric|min:' . $this->totalAmount,
        ]);

        $user = User::create([
            'name' => $this->first_name . ' ' . $this->last_name,
            'password' => bcrypt('password'),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $email,
            'role' => 'MEMBER',
        ]);

        $membership = Membership::find($this->membership_id);
        $start = Carbon::parse($this->start_date);

        if ($membership->duration_unit === 'days' && $membership->duration_value == 1) {
            $end = $start->copy();
        } else {
            $end = $start->copy()->add($membership->duration_unit, $membership->duration_value);
        }

        $this->total_amount = $membership->price;

        $userMembership = UserMembership::create([
            'user_id' => $user->id,
            'membership_id' => $this->membership_id,
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'APPROVED',
        ]);

        Payment::create([
            'type' => 'user_memberships',
            'type_id' => $userMembership->id,
            'amount' => $this->total_amount,
            'payment_method' => 'OVER_THE_COUNTER',
            'status' => 'CONFIRMED',
        ]);

        $this->userModal = false;
        $this->membership_id = null;
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';

        session()->flash('message', 'User created successfully.');
    }
}
