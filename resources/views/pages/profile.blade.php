@extends('layouts.app')

@section('content')
    <!-- Banner -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/banner-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb-text text-center text-white">
                        <h2>Profile</h2>
                        <div class="bt-option">
                            <a href="{{ url('/') }}">Home</a>
                            <span>Profile</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <livewire:profile-view />
@endsection
