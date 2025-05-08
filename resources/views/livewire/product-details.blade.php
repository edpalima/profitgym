<div class="team-section team-page spad checkout-page">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2 class="text-white pt-2">{{ $product->name }}</h2>
                <h4 class="text-success mt-3 primary-color">₱{{ number_format($product->price, 2) }}</h4>
                <p class="mt-4 text-white">In Stock: {{ $product->stock_quantity }}</p>
                <p class="mt-4">{{ $product->description }}</p>

                <a href="{{ route('products') }}" class="btn btn-outline-light mt-3">← Back to Products</a>

                @if ($product->stock_quantity > 0)
                    <button wire:click="showCheckoutModal" class="btn btn-outline-light mt-3 add-to-cart-btn">
                        <i class="fa fa-shopping-cart"></i> Order Now
                    </button>
                @elseif ($product->stock_quantity <= 0 && $product->allows_preorder)
                    <button wire:click="showCheckoutModal" class="btn btn-outline-light mt-3 add-to-cart-btn">
                        <i class="fa fa-shopping-cart"></i> Preorder
                    </button>
                @else
                    <button class="btn btn-secondary mt-3 add-to-cart-btn" disabled>
                        <i class="fa fa-shopping-cart"></i> Out of Stock
                    </button>
                @endif

                @if (session()->has('message'))
                    <div class="alert alert-success mt-3">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ✅ Inline Modal --}}
    @if ($showModal)
        <div class="modal show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.8);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content text-white border-0 rounded-4" style="background-color: #151515">
                    <form wire:submit.prevent="submitCheckout">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Checkout</h5>
                            <button type="button" class="btn-close btn-close-white"
                                wire:click="$set('showModal', false)"></button>
                        </div>

                        <div class="modal-body">
                            {{-- Display Error Message --}}
                            @if (session()->has('error'))
                                <div class="alert alert-danger mt-3">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="row">
                                {{-- Left Column --}}
                                <div class="col-md-6 border-end pe-4">
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                                            style="max-width: 150px;">
                                        <h5 class="mt-2">{{ $product->name }}</h5>
                                        <p>₱{{ number_format($product->price, 2) }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" wire:model.live="quantity"
                                            class="form-control bg-dark text-white border-secondary" min="1"
                                            @if (!$product->allows_preorder || $product->stock_quantity > 0) max="{{ $product->stock_quantity }}" @endif />
                                        @if ($quantity > $product->stock_quantity && !$product->allows_preorder)
                                            <span class="text-danger">
                                                Cannot exceed stock quantity ({{ $product->stock_quantity }})
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                {{-- Right Column --}}
                                <div class="col-md-6 ps-4">
                                    <div class="mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="text" value="₱{{ number_format($amount, 2) }}"
                                            class="form-control bg-dark text-white border-secondary" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Payment Method</label>
                                        <select wire:model.live="paymentMethod"
                                            class="form-control bg-dark text-white border-secondary">
                                            <option value="OVER_THE_COUNTER">Over the Counter</option>
                                            <option value="GCASH">GCash</option>
                                        </select>
                                        @error('paymentMethod')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @if ($paymentMethod === 'GCASH')
                                        <div class="mb-3">
                                            <label class="form-label">Scan GCash QR Code</label><br>
                                            <img src="{{ asset('img/qr/gcash.jpg') }}" alt="Scan GCash QR Code"
                                                style="max-width: 50%;">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Upload Receipt</label>
                                            <input type="file" wire:model="image" class="form-control">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Reference Number</label>
                                            <input type="text" wire:model="referenceNo"
                                                class="form-control bg-dark text-white border-secondary">
                                            @error('referenceNo')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                    <!-- Display the updated total -->
                                    <div class="mt-3 p-3 rounded" style="background-color: #f36100; color: #fff;">
                                        <strong>Total:</strong>
                                        ₱{{ number_format($amount, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-primary bg-color-primary ">Submit Order</button>
                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('showModal', false)">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
