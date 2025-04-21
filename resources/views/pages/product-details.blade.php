@extends('layouts.app')

@section('content')
    <!-- Banner -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/sidebar-banner.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb-text text-center text-white">
                        <h2>{{ $product->name }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <livewire:product-details :id="$product->id" />

    <livewire:other-products :currentProductId="$product->id" />

    {{-- Optional: Product Details Section --}}
    {{-- <section class="product-details spad" style="background-color: #1c1c1c; color: #fff; padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <h2 class="text-white">{{ $product->name }}</h2>
                    <h4 class="text-success mt-3 primary-color">₱{{ number_format($product->price, 2) }}</h4>
                    <p class="mt-4">{{ $product->description }}</p>
                    <p><strong>Stock:</strong> {{ $product->stock_quantity > 0 ? $product->stock_quantity : 'Out of stock' }}</p>
    
                    <a href="{{ url()->previous() }}" class="btn btn-outline-light mt-3">← Back to Products</a>
                    <button class="btn btn-primary mt-4" wire:click="addToCart({{ $product->id }})">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
