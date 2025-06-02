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
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AttendanceComponent extends Component
{
    public $currentDate;
    public $showOrderModal = false;
    public $showViewOrderModal = false;
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
    public $payment_amount = null;
    public $change_amount = 0;
    public $viewUserOrder;
    public $memberships;
    public $userOption = 'select';
    public $existingUsers;
    public $step = 1; // Initialize step for wizard

    protected $rules = [
        'userOption' => 'required|in:select,create',
        'first_name' => 'required_if:userOption,create|string|max:255',
        'last_name' => 'required_if:userOption,create|string|max:255',
        'membership_id' => 'required|exists:memberships,id',
        'start_date' => 'required|date',
        'payment_amount' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'userOption.required' => 'Please select whether to use an existing user or create a new one.',
        'selectedUserId.required_if' => 'Please select an existing user.',
        'selectedUserId.exists' => 'The given First Name and Last Name of a Member is already registered',
        'first_name.required_if' => 'First name is required for a new user.',
        'last_name.required_if' => 'Last name is required for a new user.',
        'membership_id.required' => 'Please select a membership.',
        'membership_id.exists' => 'The selected membership does not exist.',
        'start_date.required' => 'Please select a start date.',
        'start_date.date' => 'The start date must be a valid date.',
        'payment_amount.required' => 'Please enter a payment amount.',
        'payment_amount.min' => 'Payment amount must be at least the total amount.',
    ];

    public function mount()
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, ['ADMIN', 'STAFF'])) {
            return redirect()->route('account');
        }

        $this->currentDate = Carbon::today()->toDateString();
        $this->memberships = Membership::where('is_active', true)->get();
        $this->existingUsers = User::where('role', 'MEMBER')->get();
    }

    public function previousDate()
    {
        $this->currentDate = Carbon::parse($this->currentDate)->subDay()->toDateString();
    }

    public function getMemberships()
    {
        return Membership::where('is_active', true)->get();
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

    public function updatedSelectedProducts()
    {
        foreach ($this->selectedProducts as $productId) {
            if (!isset($this->quantities[$productId]) || $this->quantities[$productId] < 1) {
                $this->quantities[$productId] = 1;
            }
        }

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

        if ($this->totalAmount) {
            $this->changeAmount = max(0, (float) $this->paymentAmount - (float) $this->totalAmount);
        }
    }

    public function createOrder($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::find($userId);
        $this->selectedUserFullName = $user ? $user->fullName : null;
        $this->selectedProducts = [];
        $this->quantities = [];
        $this->showViewOrderModal = false;
        $this->showOrderModal = true;
        $this->paymentAmount = null;
        $this->changeAmount = 0.00;
        $this->change_amount = 0.00;
    }

    public function viewOrder($orderId): void
    {
        $this->viewUserOrder = Order::with(['orderItems.product', 'user'])->find($orderId);
        $this->showViewOrderModal = true;
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
                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

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
        $this->step = 1;
        $this->userOption = 'select';
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->membership_id = null;
        $this->start_date = now()->format('Y-m-d');
        $this->total_amount = 0;
        $this->payment_amount = null;
        $this->change_amount = 0;
        $this->selectedUserId = null;
    }

    public function generateUniqueEmail($firstName, $lastName)
    {
        $baseEmail = strtolower(str_replace(' ', '', $firstName) . '_' . str_replace(' ', '', $lastName));
        $email = $baseEmail . '@gmail.com';
        $counter = 1;

        while (User::where('email', $email)->exists()) {
            $email = $baseEmail . $counter . '@gmail.com';
            $counter++;
        }

        return $email;
    }

    public function goToNextStep()
    {
        try {
            if ($this->step == 1) {
                $this->validate([
                    'userOption' => 'required|in:select,create',
                    // 'selectedUserId' => 'required_if:userOption,select|exists:users,id',
                    'first_name' => 'required_if:userOption,create|string|max:255',
                    'last_name' => 'required_if:userOption,create|string|max:255',
                ]);

                if ($this->userOption === 'create') {
                    $existingUser = User::where('first_name', $this->first_name)
                        ->where('last_name', $this->last_name)
                        ->first();
                    if ($existingUser) {
                        throw ValidationException::withMessages([
                            'first_name' => 'A user with this first and last name already exists.',
                        ]);
                    }
                }
            } elseif ($this->step == 2) {
                $this->validate([
                    'membership_id' => 'required|exists:memberships,id',
                    'start_date' => 'required|date',
                ]);

                $userId = $this->userOption === 'select' ? $this->selectedUserId : null;
                if ($userId) {
                    $membership = Membership::find($this->membership_id);
                    $start = Carbon::parse($this->start_date);
                    $end = $membership->duration_unit === 'days' && $membership->duration_value == 1
                        ? $start->copy()
                        : $start->copy()->add($membership->duration_unit, $membership->duration_value);

                    $existingMembership = UserMembership::where('user_id', $userId)
                        ->where('membership_id', $this->membership_id)
                        ->where(function ($query) use ($start, $end) {
                            $query->whereBetween('start_date', [$start, $end])
                                ->orWhereBetween('end_date', [$start, $end])
                                ->orWhere(function ($q) use ($start, $end) {
                                    $q->where('start_date', '<=', $start)
                                        ->where('end_date', '>=', $end);
                                });
                        })
                        ->first();

                    if ($existingMembership) {
                        throw ValidationException::withMessages([
                            'membership_id' => 'This user already has an active membership of this type with overlapping dates.',
                        ]);
                    }
                }
            } elseif ($this->step == 3) {
                $this->validate([
                    'payment_amount' => 'required|numeric|min:' . $this->total_amount,
                ]);
            }
            $this->step++;
        } catch (ValidationException $e) {
            return;
        }
    }

    public function goToPreviousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function createNewUser()
    {
        $this->validate([
            'userOption' => 'required|in:select,create',
            // 'selectedUserId' => 'required_if:userOption,select|exists:users,id',
            'first_name' => 'required_if:userOption,create|string|max:255',
            'last_name' => 'required_if:userOption,create|string|max:255',
            'membership_id' => 'required|exists:memberships,id',
            'start_date' => 'required|date',
            'payment_amount' => 'required|numeric|min:' . $this->total_amount,
        ]);

        $userId = $this->userOption === 'select' ? $this->selectedUserId : null;

        if ($this->userOption === 'select' && $userId == null) {
            throw ValidationException::withMessages([
                'selectedUserId' => 'Please select a user',
            ]);
        }

        if ($this->userOption === 'create') {
            $existingUser = User::where('first_name', $this->first_name)
                ->where('last_name', $this->last_name)
                ->first();
            if ($existingUser) {
                throw ValidationException::withMessages([
                    'first_name' => 'A user with this first and last name already exists.',
                ]);
            }

            $email = $this->generateUniqueEmail($this->first_name, $this->last_name);
            $user = User::create([
                'name' => trim($this->first_name . ' ' . $this->last_name),
                'password' => bcrypt('password'),
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $email,
                'role' => User::ROLE_MEMBER,
            ]);
            $userId = $user->id;
        } else {
            $user = User::find($this->selectedUserId);
            $userId = $user->id;
        }

        $membership = Membership::find($this->membership_id);
        $start = Carbon::parse($this->start_date);
        $end = $membership->duration_unit === 'days' && $membership->duration_value == 1
            ? $start->copy()
            : $start->copy()->add($membership->duration_unit, $membership->duration_value);

        $existingMembership = UserMembership::where('user_id', $userId)
            ->where('membership_id', $this->membership_id)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                    });
            })
            ->first();

        if ($existingMembership) {
            throw ValidationException::withMessages([
                'membership_id' => 'This user already has an active membership of this type with overlapping dates.',
            ]);
        }

        $this->total_amount = $membership->price;

        $userMembership = UserMembership::create([
            'user_id' => $userId,
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

        $this->resetForm();
        session()->flash('message', 'User created successfully.');
    }

    protected function resetForm()
    {
        $this->userModal = false;
        $this->step = 1;
        $this->userOption = 'select';
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->selectedUserId = null;
        $this->membership_id = null;
        $this->start_date = null;
        $this->total_amount = 0;
        $this->payment_amount = 0;
        $this->change_amount = 0;
        $this->resetValidation();
    }

    public function render()
    {
        $users = User::where('role', 'MEMBER')
            ->with(['memberships' => function ($query) {
                $query->activeForDate($this->currentDate);
            }])
            ->whereHas('memberships', function ($query) {
                $query->activeForDate($this->currentDate);
            })
            ->get();

        $attendances = Attendance::where('date', $this->currentDate)->get()->keyBy('user_id');

        $orders = Order::with('orderItems')
            ->whereIn('user_id', $users->pluck('id'))
            ->where('created_at', '>=', "{$this->currentDate} 00:00:00")
            ->where('created_at', '<=', "{$this->currentDate} 23:59:59")
            ->get()
            ->groupBy('user_id');

        $this->totalAmount = 0;
        foreach ($this->selectedProducts as $productId) {
            $product = Product::find($productId);
            if ($product) {
                $quantity = max(1, (int) ($this->quantities[$productId] ?? 1));
                $this->totalAmount += $product->price * $quantity;
            }
        }

        return view('livewire.attendance-component', [
            'users' => $users,
            'attendances' => $attendances,
            'currentDate' => $this->currentDate,
            'orders' => $orders,
        ])->layout('layouts.attendance');
    }
}
