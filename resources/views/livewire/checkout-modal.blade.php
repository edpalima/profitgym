<div>
    @if ($showModal)
        <div class="modal show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="submit">
                        <div class="modal-header">
                            <h5 class="modal-title">Checkout</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>
                        <div class="modal-body">
                            <p>Product: {{ $product->name }}</p>
                            <p>Price: ₱{{ number_format($product->price, 2) }}</p>

                            <div class="mb-3">
                                <label>Quantity</label>
                                <input type="number" wire:model="quantity" min="1" class="form-control">
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
                            <button type="submit" class="btn btn-primary">Submit Order</button>
                            <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
