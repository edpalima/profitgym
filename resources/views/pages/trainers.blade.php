@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/banner-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Our Trainers</h2>
                        <div class="bt-option">
                            <a href="{{ url('/') }}">Home</a>
                            <span>Our trainers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Team Section Begin -->
    <section class="team-section team-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title">
                        <div class="section-title">
                            <span>Our Trainers</span>
                            <h2>TRAIN WITH EXPERTS</h2>
                        </div>
                        {{-- <a href="#" class="primary-btn btn-normal appoinment-btn">appointment</a> --}}
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($trainers as $trainer)
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="ts-item set-bg" data-setbg="{{ asset('storage/' . $trainer->image) }}">
                            <div class="ts_text">
                                <h4>{{ $trainer->first_name }} {{ $trainer->last_name }}</h4>
                                <span>{{ $trainer->specialization }}</span>
                                <div class="tt_social">
                                    <a href="https://www.facebook.com/ProfitTonesFlexes" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-youtube-play"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="mailto:{{ $trainer->email }}"><i class="fa fa-envelope-o"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Team Section End -->
@endsection
