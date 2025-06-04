<section class="gradient-custom pt-5">
    <div class="container  pt-2">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-7">
                <div class="card text-white shadow"
                    style="border-radius: 1rem; background-color: rgba(33, 37, 41, 0.658);">
                    <div class="card-body p-5">
                        @if (session()->has('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <h3 class="text-center mb-4">Enroll Membership</h3>
                        <div class="mb-4">
                            <p><strong>Name:</strong> {{ $membership->name }}</p>
                            <p><strong>Description:</strong> {{ $membership->description }}</p>
                            <p><strong>Duration:</strong> {{ $membership->duration_value }}
                                {{ ucfirst($membership->duration_unit) }}</p>
                            <p><strong>Price:</strong> ₱{{ number_format($membership->price, 2) }}</p>
                        </div>
                        @if ($userHasPendingMembership)
                            <div class="alert alert-warning">
                                You already submitted Membership Request! Wait for a while for admin to approved your
                                membership or payment
                            </div>
                        @else
                            <form wire:submit.prevent="submit" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="text" value="₱{{ number_format($amount, 2) }}" class="form-control"
                                        readonly>
                                    @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="paymentMethod" class="form-label">Payment Method</label>
                                    <select wire:model.live="paymentMethod" id="paymentMethod" class="form-control">
                                        <option value="OVER_THE_COUNTER">Over the Counter</option>
                                        <option value="GCASH">GCash</option>
                                    </select>
                                    @error('paymentMethod')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Conditionally show GCASH fields --}}
                                @if ($paymentMethod === 'GCASH')
                                    <div class="mb-3" id="gcashScanField">
                                        <label for="gcashScan" class="form-label">Scan GCash QR Code:</label>
                                        <br>
                                        <img src="{{ asset('img/qr/gcash.jpg') }}" alt="Scan GCash QR Code"
                                            style="max-width: 300px;">
                                    </div>
                                    <div class="mb-3">
                                        <label for="referenceNo" class="form-label">Reference Number</label>
                                        <input type="text" wire:model="referenceNo" id="referenceNo" pattern="[0-9]*"
                                            maxlength="13" class="form-control">
                                        @error('referenceNo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Upload Receipt</label>
                                        <input type="file" wire:model="image" class="form-control">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                {{-- Start Date --}}
                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" wire:model="startDate" id="startDate" class="form-control"
                                        min="{{ now()->toDateString() }}">
                                    @error('startDate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Terms --}}
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" wire:model="terms" id="terms"
                                            class="form-check-input">
                                        <label for="terms" class="form-check-label">
                                            I agree to the <a href="{{ route('terms-and-conditions') }}"
                                                target="_blank" class="text-decoration-none">Terms and
                                                Conditions</a>
                                        </label>
                                    </div>
                                    @error('terms')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-outline-light px-5"
                                        style="border-color: #f36100; color: #f36100;">Confirm Membership</button>
                                </div>
                            </form>
                        @endif

                        <div class="mt-4 text-center">
                            <a href="{{ route('memberships.index') }}" class="text-muted"
                                style="color: #f36100;">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
