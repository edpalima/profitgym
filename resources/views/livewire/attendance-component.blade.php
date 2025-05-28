<div id="attendanceDiv" class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button wire:click="previousDate" class="btn btn-sm px-2 py-1 border " style="background-color: #d7d7d7">
            < &nbsp;&nbsp;&nbsp;Prev </button>

                <h2 class="h6 text-center">Attendance - {{ \Carbon\Carbon::parse($currentDate)->format('F d, Y') }}</h2>

                <button wire:click="nextDate" class="btn btn-sm px-2 py-1 border " style="background-color: #d7d7d7;">
                    Next &nbsp;&nbsp;&nbsp;>
                </button>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success btn-sm px-2 py-1" wire:click="showCreateUserModal">
            + Create User Membership
        </button>
    </div>
    <!-- Mobile-responsive table wrapper -->
    <div class="table-responsive">
        @if (session()->has('message'))
            <div class="alert alert-success" id="flashMessage">
                {{ session('message') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('flashMessage').style.display = 'none';
                }, 5000);
            </script>
        @endif

        @if ($users->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                No active members for the selected date.
            </div>
        @else
            <table id="membersTable" class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Member ID</th>
                        <th>Member Name</th>
                        <th>Membership</th>
                        <th>Orders</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            $attendance = $attendances->get($user->id);
                            $startOfDay = \Carbon\Carbon::parse($currentDate)->startOfDay(); // 00:00:00
                            $endOfDay = \Carbon\Carbon::parse($currentDate)->endOfDay(); // 23:59:59

                            $membership = $user->memberships->first();
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->fullName }}</td>
                            <td>
                                @if ($membership)
                                    {{ $membership->membership->name ?? 'N/A' }}<br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($membership->start_date)->format('M d') }} -
                                        {{ \Carbon\Carbon::parse($membership->end_date)->format('M d, Y') }}
                                    </small>
                                @else
                                    <span class="text-danger">No Active</span>
                                @endif
                            </td>
                            <td>
                                @if (isset($orders[$user->id]) && $orders[$user->id]->count() > 0)
                                    <ul>
                                        @foreach ($orders[$user->id] as $order)
                                            <button wire:click="viewOrder({{ $order->id }})"
                                                class="btn btn-sm border border-primary text-primary bg-transparent">
                                                <i class="fa fa-shopping-bag me-1"></i> View Order #{{ $order->id }}
                                            </button>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>{{ $attendance && $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}
                            </td>
                            <td>{{ $attendance && $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}
                            </td>
                            <td>
                                @if (\Carbon\Carbon::parse($currentDate)->isToday())
                                    @if (!$attendance || !$attendance->time_in)
                                        <button wire:click="timeIn({{ $user->id }})"
                                            class="btn btn-success btn-sm text-white">Time In</button>
                                    @elseif ($attendance && $attendance->time_in && !$attendance->time_out)
                                        <button wire:click="timeOut({{ $user->id }})"
                                            class="btn btn-primary btn-sm text-white">Time Out</button>
                                    @endif
                                    <button wire:click="createOrder({{ $user->id }})"
                                        class="btn btn-warning btn-sm btn-create-order">Create Order</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modal for order creation -->
    @if ($showOrderModal)
        <div class="modal fade show d-block" tabindex="-1" style="padding-top: 50px; background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-white text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Create Order for {{ $selectedUserFullName }}</h5>
                        <button type="button" class="close" wire:click="$set('showOrderModal', false)"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-dark" style="max-height: 400px; overflow-y: auto;">
                        <label class="form-label">Select Products:</label>
                        <div class="form-group">
                            @php
                                $availableProducts = \App\Models\Product::where('stock_quantity', '>', 0)->get();
                            @endphp

                            @if ($availableProducts->isEmpty())
                                <div class="alert alert-warning text-center" role="alert">
                                    No products available for selection.
                                </div>
                            @else
                                @foreach ($availableProducts as $product)
                                    <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                        <div>
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.live="selectedProducts" value="{{ $product->id }}"
                                                id="prod{{ $product->id }}">
                                            <label class="form-check-label" for="prod{{ $product->id }}">
                                                {{ $product->name }} - ₱{{ number_format($product->price, 2) }} <span
                                                    class="text-muted">(Stock: {{ $product->stock_quantity }})</span>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="number" min="1" max="{{ $product->stock_quantity }}"
                                                class="form-control form-control-sm"
                                                wire:model.live="quantities.{{ $product->id }}" placeholder="Qty"
                                                style="width: 70px;" @disabled(!in_array($product->id, $selectedProducts))>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @error('selectedProducts')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <div class="text-end mt-3">
                            <strong>Total: ₱{{ number_format($totalAmount, 2) }}</strong>
                        </div>

                        <hr>
                        <div class="form-group mt-3">
                            <label class="form-label">Payment Amount:</label>
                            <input type="number" min="0" step="0.01" class="form-control"
                                wire:model.live="paymentAmount" placeholder="Enter payment (₱)">
                        </div>

                        @if ($changeAmount > 0 && $paymentAmount <= 0)
                            <div class="form-group mt-2 text-end">
                                <strong>Change: ₱{{ number_format($changeAmount, 2) }}</strong>
                            </div>
                        @endif

                        @error('paymentAmount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showOrderModal', false)">Cancel</button>
                        <button type="button" class="btn btn-create-order" wire:click="submitOrder"
                            @if ($paymentAmount <= 0 && empty($selectedProducts)) disabled @endif>
                            Confirm Payment and Submit Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Modal for new user creation -->
    @if ($userModal)
        <div class="modal fade show d-block" tabindex="-1"
            style="padding-top: 50px; background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-white text-dark" style="height: 80vh;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Create New Member</h5>
                        <button type="button" class="close" wire:click="$set('userModal', false)" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-dark" style="max-height: 600px; overflow-y: auto;">
                        <!-- Progress Indicator -->
                        <div class="mb-4">
                            <ul class="nav nav-pills nav-fill">
                                <li class="nav-item">
                                    <span
                                        class="nav-link {{ $step == 1 ? 'active btn-sm btn-create-order' : '' }}">Step
                                        1: User
                                        Selection</span>
                                </li>
                                <li class="nav-item">
                                    <span
                                        class="nav-link {{ $step == 2 ? 'active btn-sm btn-create-order' : '' }}">Step
                                        2: Membership</span>
                                </li>
                                <li class="nav-item">
                                    <span
                                        class="nav-link {{ $step == 3 ? 'active btn-sm btn-create-order' : '' }}">Step
                                        3: Payment</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Step 1: User Selection -->
                        @if ($step == 1)
                            <div class="mb-3">
                                <label class="form-label">User Option</label>
                                <select class="form-control" wire:model.live="userOption">
                                    <option value="select">Select Existing User</option>
                                    <option value="create">Create New User</option>
                                </select>
                            </div>
                            @if ($userOption === 'select')
                                <div class="mb-3">
                                    <label class="form-label">Select Existing User</label>
                                    <select class="form-control" wire:model="selectedUserId">
                                        <option value="">-- Choose User --</option>
                                        @foreach ($existingUsers as $user)
                                            <option value="{{ $user->id }}">{{ $user->fullName }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedUserId')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror SERVICES
                                </div>
                            @endif
                            @if ($userOption === 'create')
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" id="first_name" wire:model.defer="first_name"
                                        class="form-control">
                                    @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" id="last_name" wire:model.defer="last_name"
                                        class="form-control">
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        @endif

                        <!-- Step 2: Membership Selection -->
                        @if ($step == 2)
                            <div class="mb-3">
                                <label for="membership_id" class="form-label">Select Membership</label>
                                <select id="membership_id" wire:model.live="membership_id" class="form-control">
                                    <option value="">-- Select Membership --</option>
                                    @foreach ($memberships as $membership)
                                        <option value="{{ $membership->id }}">{{ $membership->name }} -
                                            ₱{{ number_format($membership->price, 2) }}</option>
                                    @endforeach
                                </select>
                                @error('membership_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Select Start Date</label>
                                <input type="date" id="start_date" wire:model="start_date" class="form-control">
                                @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <!-- Step 3: Payment Details -->
                        @if ($step == 3)
                            <div class="mb-3">
                                <label for="total_amount" class="form-label">Total Amount</label>
                                <input type="text" id="total_amount" wire:model.live="total_amount"
                                    class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Amount:</label>
                                <input type="number" min="0" step="0.01" class="form-control"
                                    wire:model.live="payment_amount" placeholder="Enter payment (₱)">
                            </div>
                            <div class="mb-3">
                                <strong>Change: ₱{{ number_format($change_amount, 2) }}</strong>
                            </div>
                        @endif
                        @if ($userModal && $errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($step == 1)
                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('userModal', false)">Cancel</button>
                        @endif
                        @if ($step > 1)
                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('step', {{ $step - 1 }})">Back</button>
                        @endif
                        @if ($step < 3)
                            <button type="button" class="btn btn-primary btn-sm btn-create-order"
                                wire:click="$set('step', {{ $step + 1 }})">Next</button>
                        @else
                            <button type="button" class="btn btn-primary btn-sm btn-create-order"
                                wire:click="createNewUser">Create
                                Member</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Modal for order creation -->
    @if ($showViewOrderModal)
        <div class="modal fade show d-block" tabindex="-1" style="padding-top: 50px; background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-white text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel">Order #{{ $viewUserOrder->id }} for
                            {{ $order->user->fullName }}
                        </h5><br>
                        <button type="button" class="close" wire:click="$set('showViewOrderModal', false)"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <div wire:loading wire:target="viewOrder">
                        <p>Loading order details...</p>
                    </div> --}}
                    <div class="modal-body text-dark" style="max-height: 400px; overflow-y: auto;">
                        {{-- {{dd($order)}} --}}
                        @if ($viewUserOrder)
                            <h6 class="text-muted">Product Information:</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($viewUserOrder->orderItems as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td>₱{{ number_format($item->product->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>₱{{ number_format($item->product->price * $item->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Total:</th>
                                            <th>₱{{ number_format($viewUserOrder->total_amount, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showViewOrderModal', false)">Cancel</button>
                        <button type="button" class="btn btn-warning btn-create-order"
                            wire:click="createOrder({{ $viewUserOrder->user->id }})">Create Order</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
