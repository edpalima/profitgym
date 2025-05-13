<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button wire:click="previousDate" class="btn btn-secondary px-4 py-2">Previous</button>
        <h2 class="h4 text-center">Attendance - {{ \Carbon\Carbon::parse($currentDate)->format('F d, Y') }}</h2>
        <button wire:click="nextDate" class="btn btn-secondary px-4 py-2">Next</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th class="px-4 py-2">Member</th>
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
                            <button wire:click="timeIn({{ $user->id }})" class="btn btn-success btn-sm">Time
                                In</button>
                            <button wire:click="timeOut({{ $user->id }})" class="btn btn-primary btn-sm">Time
                                Out</button>
                            <button wire:click="createOrder({{ $user->id }})" class="btn btn-warning btn-sm">Create
                                Order</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($showOrderModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-white text-dark"> {{-- Ensure white background and dark text --}}
                    <div class="modal-header">
                        <h5 class="modal-title text-dark">Create Order for User #{{ $selectedUserId }}</h5>
                        <button type="button" class="close" wire:click="$set('showOrderModal', false)">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-dark">
                        <label class="form-label">Select Products:</label>
                        <div class="form-group">
                            @foreach (\App\Models\Product::all() as $product)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="selectedProducts"
                                        value="{{ $product->id }}" id="prod{{ $product->id }}">
                                    <label class="form-check-label text-dark" for="prod{{ $product->id }}">
                                        {{ $product->name }} - ${{ number_format($product->price, 2) }}
                                    </label>
                                </div>
                            @endforeach
                            @error('selectedProducts')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showOrderModal', false)">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="submitOrder">Submit Order</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
