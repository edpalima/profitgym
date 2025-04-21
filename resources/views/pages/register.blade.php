@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg position-relative full-header"
        style="height: 1200px;"
        data-setbg="{{ asset('img/breadcrumb-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <div class="bt-option">
                            <livewire:auth.register />
                            {{-- <a href="{{ url('/') }}">Home</a> --}}
                            {{-- <span>Our trainers</span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Team Section Begin -->
    {{-- <section class="team-section team-page spad">
        <div class="container">
            <livewire:auth.register />
        </div>
    </section> --}}
    <!-- Team Section End -->
@endsection
