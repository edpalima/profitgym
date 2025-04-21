@extends('layouts.app')

@section('content')
    <section class="breadcrumb-section set-bg position-relative full-header" data-setbg="{{ asset('img/banner-bg.jpg') }}"
        style="height: 1450px;"
    >
        <div class="bg-overlay"></div>
        <div class="container py-5"> <!-- Adjust padding for spacing -->
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <div class="bt-option">
                            <!-- Added some padding to ensure content stays within the section -->
                            @livewire('membership-checkout', ['membershipId' => $membership->id])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection