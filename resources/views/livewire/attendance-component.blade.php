<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button wire:click="previousDate" class="btn btn-secondary px-4 py-2">Previous</button>
        <h2 class="h4 text-center">Attendance - {{ \Carbon\Carbon::parse($currentDate)->format('F d, Y') }}</h2>
        <button wire:click="nextDate" class="btn btn-secondary px-4 py-2">Next</button>
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
            <!-- Display message if no users are found -->
            <div class="alert alert-info text-center" role="alert">
                No active members for the selected date.
            </div>
        @else
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-2">Member ID</th>
                        <th class="px-4 py-2">Member Name</th>
                        <th class="px-4 py-2">Membership</th>
                        <th class="px-4 py-2">Time In</th>
                        <th class="px-4 py-2">Time Out</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            $attendance = $attendances->get($user->id);
                            $membership = $user
                                ->memberships()
                                ->where('is_active', true)
                                ->where('status', 'APPROVED')
                                ->whereDate('start_date', '<=', now())
                                ->whereDate('end_date', '>=', now())
                                ->first();
                        @endphp
                        <tr>
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2">{{ $user->fullName }}</td>
                            <td class="px-4 py-2">
                                @if ($membership)
                                    {{ $membership->membership->name ?? 'N/A' }}
                                    <br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($membership->start_date)->format('M d') }} -
                                        {{ \Carbon\Carbon::parse($membership->end_date)->format('M d, Y') }}
                                    </small>
                                @else
                                    <span class="text-danger">No Active</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                {{ $attendance && $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $attendance && $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}
                            </td>
                            <td class="px-4 py-2">
                                @if (\Carbon\Carbon::parse($currentDate)->isToday())
                                    @if (!$attendance || !$attendance->time_in)
                                        <button wire:click="timeIn({{ $user->id }})"
                                            class="btn btn-success btn-sm">Time
                                            In</button>
                                    @elseif ($attendance && $attendance->time_in && !$attendance->time_out)
                                        <button wire:click="timeOut({{ $user->id }})"
                                            class="btn btn-primary btn-sm">Time Out</button>
                                    @endif
                                    <button wire:click="createOrder({{ $user->id }})"
                                        class="btn btn-warning btn-sm">Create Order</button>
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
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-white text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark">Create Order for Member #{{ $selectedUserId }}</h5>
                        <button type="button" class="close" wire:click="$set('showOrderModal', false)">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-dark">
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
                                            <label class="form-check-label text-dark" for="prod{{ $product->id }}">
                                                {{ $product->name }} - ₱{{ number_format($product->price, 2) }} <span
                                                    class="text-muted">(Stock:
                                                    {{ $product->stock_quantity }}) </span>
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

                        <div class="form-group mt-2 text-end">
                            <strong>Change: ₱{{ number_format($changeAmount, 2) }}</strong>
                        </div>

                        @error('paymentAmount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showOrderModal', false)">Cancel</button>
                        <button type="button" class="btn btn-primary bg-color-primary" wire:click="submitOrder">Confirm
                            Payment and Submit Order</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
