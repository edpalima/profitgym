<div class="team-section team-page spad" style="background-color: #1c1c1c; padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-5">
                    <span style="color: #f36100;">OTHER PRODUCTS</span>
                    <h2 style="color: #fff;">MORE SUPPLEMENTS YOU MIGHT LIKE</h2>
                </div>
            </div>
        </div>
        
        <div class="row">
            @foreach ($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="product-item h-100"
                    style="background-color: #282828; padding: 20px; border-radius: 8px; text-align: center; display: flex; flex-direction: column; transition: transform 0.3s ease;">
                    
                    <a href="{{ route('product.show', $product->id) }}" 
                       style="flex: 1; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            style="max-width: 100%; max-height: 180px; width: auto; height: auto; object-fit: contain; transition: transform 0.3s ease;">
                    </a>
        
                    <div>
                        <h5 style="color: #fff; font-size: 1.1rem; margin-bottom: 0.5rem;">{{ $product->name }}</h5>
                        <p style="color: #bbb; font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem;">₱{{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('product.show', $product->id) }}"
                            class="btn btn-sm view-details-btn" 
                            style="background-color: #f36100; color: white; border-radius: 4px; padding: 8px 20px; transition: all 0.3s ease;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <style>
        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .product-item:hover img {
            transform: scale(1.05);
        }
        
        .view-details-btn:hover {
            background-color: #e05500 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</div>