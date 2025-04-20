<section class="gradient-custom py-5">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-7">
                <div class="card text-white shadow" style="border-radius: 1rem; background-color: rgba(33, 37, 41, 0.658);">
                    <div class="card-body p-5">
                        @if (session()->has('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <h3 class="text-center mb-4">Membership Checkout</h3>

                        <div class="mb-4">
                            <p><strong>Name:</strong> {{ $membership->name }}</p>
                            <p><strong>Description:</strong> {{ $membership->description }}</p>
                            <p><strong>Duration:</strong> {{ $membership->duration_value }} {{ ucfirst($membership->duration_unit) }}</p>
                            <p><strong>Price:</strong> ₱{{ number_format($membership->price, 2) }}</p>
                        </div>

                        <form wire:submit.prevent="submit" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select wire:model="payment_method" id="payment_method" class="form-control">
                                    <option value="over_the_counter">Over the Counter</option>
                                    <option value="gcash">GCash</option>
                                </select>
                                @error('payment_method') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Receipt (Optional)</label>
                                <input type="file" wire:model="image" class="form-control">
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description (Optional)</label>
                                <textarea wire:model="description" class="form-control" rows="2"></textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-light px-5"
                                    style="border-color: #f36100; color: #f36100;">Confirm Membership</button>
                            </div>
                        </form>

                        <div class="mt-4 text-center">
                            <a href="{{ route('memberships.index') }}" class="text-muted" style="color: #f36100;">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
