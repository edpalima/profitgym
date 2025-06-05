@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/about-us.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2 class="text-white">Terms and Conditions</h2>
                        <div class="bt-option">
                            <a href="{{ url('/') }}">Home</a>
                            <span>Terms and Conditions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Content Section Begin -->
    <section class="team-section team-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title">
                    </div>
                </div>
            </div>
            <div class="mb-4 terms-content">
                @php
                    $terms = \App\Models\TermsPolicy::latest()->first();
                @endphp
                
                @if($terms)
                    <h1 class="mb-4 text-white">{{ $terms->title }}</h1>
                    <div class="last-updated mb-4 text-muted">
                        Last updated: {{ $terms->updated_at->format('F j, Y') }}
                    </div>
                    {!! $terms->content !!}
                @else
                    <div class="alert alert-info text-center">
                        <p>Terms and conditions content will appear here once configured by admin.</p>
                        @can('create', App\Models\TermsPolicy::class)
                            <a href="{{ route('filament.admin.resources.terms-policies.create') }}" class="btn btn-primary mt-2">
                                Create Terms & Conditions
                            </a>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Content Section End -->
@endsection

@section('styles')
<style>
    .terms-content {
        line-height: 1.8;
        color: #555;
    }
    .terms-content h1 {
        font-size: 2rem;
        color: #333;
        margin-bottom: 1.5rem;
    }
    .terms-content h2 {
        font-size: 1.5rem;
        color: #333;
        margin: 2rem 0 1rem;
    }
    .terms-content h3 {
        font-size: 1.25rem;
        color: #333;
        margin: 1.5rem 0 0.75rem;
    }
    .terms-content p {
        margin-bottom: 1.5rem;
    }
    .terms-content ul, 
    .terms-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    .terms-content ul li,
    .terms-content ol li {
        margin-bottom: 0.5rem;
    }
    .terms-content a {
        color: #007bff;
        text-decoration: underline;
    }
    .last-updated {
        font-style: italic;
        font-size: 0.9rem;
    }
</style>
@endsection