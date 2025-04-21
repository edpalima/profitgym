@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg position-relative full-header" data-setbg="{{ asset('img/breadcrumb-bg.jpg') }}"
        style="height: 1200px;">
        <div class="bg-overlay"></div>
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="row w-100">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <div class="bt-option">
                            <livewire:auth.login />
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
        </div>
    </section> --}}
    <!-- Team Section End -->
@endsection
