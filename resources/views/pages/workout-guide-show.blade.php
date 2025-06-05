@extends('layouts.app')

@section('content')
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
                        
                        @if($workoutGuide->video_path)
                            <div class="mt-5 video-container">
                                <video controls class="w-100" style="max-height: 500px;">
                                    <source src="{{ url('storage/' . $workoutGuide->video_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endif
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
@endsection

@push('styles')
<style>
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
    }
    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
@endpush