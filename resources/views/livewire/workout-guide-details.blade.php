@extends('layouts.app')

@section('content')
<div class="workout-guide-details">
    <section class="spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>{{ $workoutGuide->title }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="workout-guide-item">
                        <div class="wg-pic">
                            <img src="{{ asset('storage/' . $workoutGuide->featured_photo) }}" alt="{{ $workoutGuide->title }}">
                        </div>
                        <div class="wg-text">
                            <h5>Description</h5>
                            <div class="wg-description">
                                {!! $workoutGuide->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
