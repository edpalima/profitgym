@extends('layouts.app')

@section('content')
    {{-- {{ dd($workoutGuide->featured_photo) }} --}}
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg position-relative"
        data-setbg="{{ url('storage/' . $workoutGuide->featured_photo) }}">
        <div class="bg-overlay"></div> {{-- Dark overlay --}}
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>{{ $workoutGuide->title }}</h2>
                        <div class="bt-option">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="#">Workout Guide</a>
                            <span>{{ $workoutGuide->title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Class Details Section Begin -->
    <section class="class-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="class-details-text">
                        {!! $workoutGuide->description !!}
                        {!! $workoutGuide->video_url !!}
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="sidebar-option">
                      @livewire('other-workout-guides', ['currentWorkoutId' => $workoutGuide->id])
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Get In Touch Section End -->
@endsection
