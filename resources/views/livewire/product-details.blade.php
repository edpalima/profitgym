<div class="product-details-container" style="background-color: #1a1a1a; color: white;">
    <div class="team-section team-page spad checkout-page">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 500px; width: auto; object-fit: contain;">
                </div>
                <div class="col-md-6 text-white">
                    <h2 class="pt-2" style="color: #ffffff;">{{ $product->name }}</h2>
                    <h4 class="mt-3" style="color: #FF7F00;">₱{{ number_format($product->price, 2) }}</h4>
                    <p class="mt-4">In Stock: {{ $product->stock_quantity }}</p>
                    <p class="mt-4">{{ $product->description }}</p>

                    <a href="{{ route('products') }}" class="btn btn-outline-light mt-3">← Back to Products</a>

                    @if ($product->stock_quantity > 0)
                    <button wire:click="showCheckoutModal" class="btn btn-outline-light mt-3 add-to-cart-btn">
                        Order Now
                    </button>
                    @elseif ($product->stock_quantity <= 0 && $product->allows_preorder)
                        <button wire:click="showCheckoutModal" class="btn mt-3" style="background-color: #FF7F00; color: white;">
                            Preorder
                        </button>
                    @else
                        <button class="btn btn-secondary mt-3" disabled>
                            Out of Stock
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

        @if ($showModal)
        <div class="modal-backdrop" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1040;">
            <div class="modal-dialog modal-lg modal-dialog-centered" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; width: 90%; max-width: 800px;">
                <div class="modal-content" style="background: #1a1a1a; border: 1px solid #333; border-radius: 8px; overflow: hidden;">
                    <form wire:submit.prevent="submitCheckout">
                        <div class="modal-header" style="border-bottom: 1px solid #333; padding: 1.5rem; background: #222;">
                            <h5 class="modal-title" style="color: #FF7F00; font-weight: 600;">Complete Your Order</h5>
                            <button type="button" class="btn-close btn-close-white" wire:click="$set('showModal', false)"></button>
                        </div>

                        <div class="modal-body" style="max-height: 60vh; overflow-y: auto; padding: 1.5rem; color: white;">
                            @if (session()->has('error'))
                                <div class="alert alert-danger" style="border-left: 4px solid #dc3545; background-color: rgba(220, 53, 69, 0.15); border-radius: 6px; padding: 0.75rem 1rem;">
                                    {{ session('error') }}
                                </div>
                            @endif
                            
                            <div class="row g-4">
                                <div class="col-md-6 pe-md-4">
                                    <div class="product-summary" style="background: #222; border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-3" style="max-height: 250px; width: auto; object-fit: contain; border: 1px solid #333;">
                                            <h5 class="mt-3 fw-bold" style="color: #FF7F00;">{{ $product->name }}</h5>
                                            <div style="color: #FF7F00; font-size: 1.25rem; font-weight: 600;">₱{{ number_format($product->price, 2) }}</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" style="color: #aaa; font-size: 0.8rem; margin-bottom: 0.5rem;">QUANTITY</label>
                                            <input type="number" wire:model.live="quantity" class="form-control" style="background: #2a2a2a; border: 1px solid #333; color: white; border-radius: 4px; padding: 0.5rem 1rem;"
                                                min="1" @if (!$product->allows_preorder || $product->stock_quantity > 0) max="{{ $product->stock_quantity }}" @endif>
                                            @if ($quantity > $product->stock_quantity && !$product->allows_preorder)
                                                <span class="text-danger" style="font-size: 0.8rem; margin-top: 0.5rem; display: block;">
                                                    Cannot exceed stock quantity ({{ $product->stock_quantity }})
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-md-4">
                                    <div class="mb-4">
                                        <label class="form-label" style="color: #aaa; font-size: 0.8rem; margin-bottom: 0.5rem;">AMOUNT</label>
                                        <input type="text" value="₱{{ number_format($amount, 2) }}" class="form-control" style="background: #2a2a2a; border: 1px solid #333; color: white; border-radius: 4px; padding: 0.5rem 1rem;" readonly>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" style="color: #aaa; font-size: 0.8rem; margin-bottom: 0.5rem;">PAYMENT METHOD</label>
                                        <div class="d-flex gap-2">
                                            <button type="button" wire:click="$set('paymentMethod', 'OVER_THE_COUNTER')" 
                                                class="flex-grow-1 py-2 payment-method-btn" 
                                                style="background: {{ $paymentMethod === 'OVER_THE_COUNTER' ? '#FF7F00' : '#2a2a2a' }}; 
                                                       color: {{ $paymentMethod === 'OVER_THE_COUNTER' ? 'white' : '#aaa' }}; 
                                                       border: 1px solid #333; 
                                                       border-radius: 4px;
                                                       transition: all 0.3s ease;">
                                                Over the Counter
                                            </button>
                                            <button type="button" wire:click="$set('paymentMethod', 'GCASH')" 
                                                class="flex-grow-1 py-2 payment-method-btn" 
                                                style="background: {{ $paymentMethod === 'GCASH' ? '#FF7F00' : '#2a2a2a' }}; 
                                                       color: {{ $paymentMethod === 'GCASH' ? 'white' : '#aaa' }}; 
                                                       border: 1px solid #333; 
                                                       border-radius: 4px;
                                                       transition: all 0.3s ease;">
                                                GCash
                                            </button>
                                        </div>
                                        @error('paymentMethod')
                                            <span class="text-danger" style="font-size: 0.8rem; margin-top: 0.5rem; display: block;">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    @if ($paymentMethod === 'GCASH')
                                        <div class="gcash-payment-details" style="background: #222; border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
                                            <label class="form-label" style="color: #aaa; font-size: 0.8rem; margin-bottom: 0.5rem;">SCAN GCASH QR CODE</label>
                                            <div class="text-center my-3">
                                                <img src="{{ asset('img/qr/gcash.jpg') }}" alt="GCash QR Code" class="img-fluid rounded-3" style="max-width: 200px; border: 1px solid #333;">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" style="color: #aaa; font-size: 0.8rem; margin-bottom: 0.5rem;">UPLOAD PAYMENT RECEIPT</label>
                                                <div style="position: relative;">
                                                    <!-- Hidden actual file input -->
                                                    <input type="file" wire:model="image" id="file-upload-input" 
                                                        accept="image/*" 
                                                        style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">
                                                    
                                                    <!-- Custom styled file input -->
                                                    <div style="
                                                        background: #2a2a2a;
                                                        border: 1px solid #333;
                                                        border-radius: 4px;
                                                        padding: 0.5rem;
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: space-between;
                                                        min-height: 42px;
                                                    ">
                                                        <span id="file-name-display" style="
                                                            color: #aaa;
                                                            font-size: 0.9rem;
                                                            padding-left: 0.5rem;
                                                            overflow: hidden;
                                                            text-overflow: ellipsis;
                                                            white-space: nowrap;
                                                            flex-grow: 1;
                                                        ">
                                                            @if($image)
                                                                {{ is_string($image) ? $image : $image->getClientOriginalName() }}
                                                            @else
                                                                No file selected
                                                            @endif
                                                        </span>
                                                        <button type="button" onclick="document.getElementById('file-upload-input').click()" style="
                                                            background-color: #FF7F00;
                                                            color: white;
                                                            border: none;
                                                            border-radius: 4px;
                                                            padding: 0.375rem 0.75rem;
                                                            font-size: 0.8rem;
                                                            cursor: pointer;
                                                            transition: background-color 0.2s;
                                                        " onmouseover="this.style.backgroundColor='#e67300'" 
                                                        onmouseout="this.style.backgroundColor='#FF7F00'">
                                                            Input Receipt
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('image')
                                                    <span class="text-danger" style="font-size: 0.8rem; margin-top: 0.5rem; display: block;">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" style="color: #aaa; font-size: 0.8rem; margin-bottom: 0.5rem;">REFERENCE NUMBER</label>
                                                <input type="text" wire:model="referenceNo" max="10000000000000" pattern="[0-9]*" maxlength="13"
                                                    title="Numbers only" class="form-control" style="background: #2a2a2a; border: 1px solid #333; color: white; border-radius: 4px; padding: 0.5rem 1rem;"
                                                    placeholder="Enter 13-digit reference number">
                                                @error('referenceNo')
                                                    <span class="text-danger" style="font-size: 0.8rem; margin-top: 0.5rem; display: block;">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input type="checkbox" wire:model="terms" id="terms" class="form-check-input" style="background: #2a2a2a; border: 1px solid #333;">
                                            <label for="terms" class="form-check-label" style="font-size: 0.9rem; color: white;">
                                                I agree to the <a href="{{ route('terms-and-conditions') }}" target="_blank" style="color: #FF7F00; text-decoration: underline;">Terms and Conditions</a>
                                            </label>
                                        </div>
                                        @error('terms')
                                            <span class="text-danger" style="font-size: 0.8rem; margin-top: 0.5rem; display: block;">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="total-summary" style="background: #222; border-radius: 8px; padding: 1rem; text-align: center;">
                                        <div style="color: #aaa; font-size: 0.8rem;">TOTAL PAYMENT</div>
                                        <div style="color: #FF7F00; font-size: 1.5rem; font-weight: 600;">₱{{ number_format($amount, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer" style="border-top: 1px solid #333; padding: 1.25rem 1.5rem; background: #222;">
                            <button type="button" class="btn btn-outline-light" wire:click="$set('showModal', false)" style="border-radius: 4px; padding: 0.5rem 1.5rem; border: 1px solid #333;">
                                Cancel
                            </button>
                            <button type="submit" class="btn" style="background-color: #FF7F00; border-color: #FF7F00; color: white; border-radius: 4px; padding: 0.5rem 1.5rem; font-weight: 500;">
                                Submit Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <style>
        .payment-method-btn:hover {
            background-color: #FF7F00 !important;
            color: white !important;
            border-color: #FF7F00 !important;
        }
        
        .btn-outline-light:hover {
            background-color: #FF7F00;
            border-color: #FF7F00;
            color: white;
        }
        
        .btn[style*="background-color: #FF7F00"]:hover {
            background-color: #e67300 !important;
            border-color: #e67300 !important;
        }
        
        .form-control:focus {
            border-color: #FF7F00;
            box-shadow: 0 0 0 0.25rem rgba(255, 127, 0, 0.25);
        }
        
        .form-check-input:checked {
            background-color: #FF7F00;
            border-color: #FF7F00;
        }
    </style>
</div>

<script>
    document.getElementById('file-upload-input')?.addEventListener('change', function(e) {
        const fileInput = e.target;
        const fileNameDisplay = document.getElementById('file-name-display');
        
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            // Check if the file is an image
            if (!file.type.match('image.*')) {
                alert('Please select an image file (JPEG, PNG, etc.)');
                fileInput.value = ''; // Clear the file input
                fileNameDisplay.textContent = 'No file selected';
                return;
            }
            fileNameDisplay.textContent = file.name;
        } else {
            fileNameDisplay.textContent = 'No file selected';
        }
    });
</script>