@extends('layouts.app')

@section('content')
    <!-- Banner -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/banner-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb-text text-center text-white">
                        <h2>Our Products</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="team-section team-page spad">
        <div class="container">
            <div class="row">
                <livewire:product-list />
            </div>
        </div>
    </section>
@endsection
