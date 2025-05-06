<div class="team-section team-page spad">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2 class="text-white pt-2">{{ $product->name }}</h2>
                <h4 class="text-success mt-3 primary-color">₱{{ number_format($product->price, 2) }}</h4>
                <p class="mt-4">{{ $product->description }}</p>

                <a href="{{ route('products') }}" class="btn btn-outline-light mt-3">← Back to Products</a>

                {{-- ✅ Trigger checkout modal --}}
                <button wire:click="showCheckoutModal" class="btn btn-outline-light mt-3 add-to-cart-btn">
                    <i class="fa fa-shopping-cart"></i> Buy Now
                </button>

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
        <div class="modal show d-block" style="background-color: rgba(0,0,0,0.5)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="submitCheckout">
                        <div class="modal-header">
                            <h5 class="modal-title">Checkout</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Product:</strong> {{ $product->name }}</p>
                            <p><strong>Price:</strong> ₱{{ number_format($product->price, 2) }}</p>

                            <div class="mb-3">
                                <label>Quantity</label>
                                <input type="number" wire:model="quantity" class="form-control" min="1">
                            </div>

                            <div class="mb-3">
                                <label>Payment Method</label>
                                <input type="text" wire:model="paymentMethod" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Reference No</label>
                                <input type="text" wire:model="referenceNo" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary add-to-cart-btn">Submit Order</button>
                            <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
