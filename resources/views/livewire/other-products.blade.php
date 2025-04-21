<div class="team-section team-page spad">
    <div class="container">
        <div class="col-lg-12">
            <div class="col-12 team-title">
                <div class="section-title">
                    <span>Other Products</span>
                </div>
                {{-- <a href="#" class="primary-btn btn-normal appoinment-btn">appointment</a> --}}
            </div>
        </div>
        <div class="row col-12 mt-2">
            {{-- <div class="col-12 text-center mb-4">
                <h4 style="color: #fff;">Other Products</h4>
            </div> --}}
            @foreach ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="product-item"
                    style="background-color: #282828; padding: 20px; border-radius: 8px; text-align: center;">
                    
                    <a href="{{ route('product.show', $product->id) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            style="max-width: 100%; height: auto; margin-bottom: 15px;">
                    </a>
        
                    <h5 style="color: #fff;">{{ $product->name }}</h5>
                    <p style="color: #bbb;">₱{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('product.show', $product->id) }}"
                        class="btn btn-sm btn-outline-light mt-2">View</a>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
