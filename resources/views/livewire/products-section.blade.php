<section class="product-section spad" style="background-color: #1c1c1c; color: #fff; padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <span>OUR PRODUCTS</span>
                    <h2 style="color: #fff;">BUY OUR RECENT PRODUCTS</h2>
                    <p class="pt-4">With a background of creating some of the most life-changing supplements in the industry, the ProFit Gym team brings you the most advanced nutritional supplements on the market, made with only the purest and highest quality.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($products as $product)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="product-item" style="background-color: #282828; padding: 20px; border-radius: 8px; text-align: center;">
                    <a href="{{ route('product.show', $product->id) }}">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="max-width: 100%; height: auto; margin-bottom: 15px;">
                    </a>
                    <h3 style="color: #fff;">{{ $product->name }}</h3>
                    {{-- <div class="pi-rating" style="margin: 10px 0;">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                    </div> --}}
                </div>
            </div>
        @endforeach
        <a href="{{ route('products') }}" class="primary-btn btn-normal appoinment-btn">See More</a>
        </div>
    </div>
</section>
