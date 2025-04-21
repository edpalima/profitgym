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
                {{-- <p><strong>Stock:</strong>
                    {{ $product->stock_quantity > 0 ? $product->stock_quantity : 'Out of stock' }}</p> --}}

                <a href="{{ route('products')}}" class="btn btn-outline-light mt-3">← Back to Products</a>
                <a href="{{ url()->previous() }}" class="btn btn-outline-light mt-3 add-to-cart-btn">
                    <i class="fa fa-shopping-cart"></i> Add to Cart
                </a>

                @if (session()->has('message'))
                    <div class="alert alert-success mt-3">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
