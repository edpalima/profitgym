@extends('layouts.app')

@section('content')
    <section class="breadcrumb-section set-bg position-relative full-header" data-setbg="{{ asset('img/banner-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="row w-100">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <div class="bt-option">
                            @livewire('membership-checkout', ['membershipId' => $membership->id])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
