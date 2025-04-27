@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/breadcrumb-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Gallery</h2>
                        <div class="bt-option">
                            <a href="{{ url('/') }}">Home</a>
                            <span>Gallery</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Gallery Section Begin -->
    <div class="gallery-section gallery-page">
        <div class="gallery">
            <div class="grid-sizer"></div>
            @foreach ($galleries as $gallery)
                <div class="gs-item set-bg" data-setbg="{{ asset('storage/' . $gallery->image) }}">
                    <a href="{{ asset('storage/' . $gallery->image) }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Team Section End -->
@endsection
