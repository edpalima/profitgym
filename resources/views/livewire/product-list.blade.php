<section class="product-section spad" style="background-color: #1c1c1c; color: #fff; padding: 60px 0;">
    <div class="container">
        {{-- Title --}}
        <div class="row mb-5">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <span>OUR PRODUCTS</span>
                    <h2 style="color: #fff;">BUY OUR RECENT PRODUCTS</h2>
                    <p class="pt-4">With a background of creating some of the most life-changing supplements in the
                        industry, the ProFit Gym team brings you the most advanced nutritional supplements on the
                        market, made with only the purest and highest quality.</p>
                </div>
            </div>
        </div>

        {{-- Filters + Products Grid --}}
        <div class="row">
            {{-- Filters Sidebar --}}
            <div class="col-lg-3 mb-4">
                <div class="p-4" style="background-color: #2c2c2c; border-radius: 8px;">
                    <h5 style="color: #fff;">Filter Products</h5>
                    <div class="form-group mt-3">
                        <label for="search" style="color: #bbb;">Search</label>
                        <input type="text" wire:model="searchInput" class="form-control"
                            placeholder="Product name...">
                    </div>
                    <div class="form-group mt-3">
                        <label style="color: #bbb;">Min Price</label>
                        <input type="number" wire:model="minPrice" class="form-control" placeholder="₱0">
                    </div>
                    <div class="form-group mt-3">
                        <label style="color: #bbb;">Max Price</label>
                        <input type="number" wire:model="maxPrice" class="form-control" placeholder="₱9999">
                    </div>
                    {{-- <div class="form-check mt-3">
                        <input type="checkbox" wire:model="inStockOnly" class="form-check-input" id="inStockOnly">
                        <label class="form-check-label" for="inStockOnly" style="color: #bbb;">In Stock Only</label>
                    </div> --}}
                    <button wire:click="applyFilters" class="btn btn-primary btn-block mt-3"
                        style="background-color: #f36100">Search</button>
                </div>
            </div>

            {{-- Products Listing --}}
            <div class="col-lg-9">
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="product-item"
                                style="background-color: #282828; padding: 20px; border-radius: 8px; text-align: center;">

                                <a href="{{ route('product.show', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        style="max-width: 100%; height: auto; margin-bottom: 15px;">
                                </a>

                                <h3 style="color: #fff;">{{ $product->name }}</h3>
                                <p style="color: #bbb;">₱{{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No products found.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
