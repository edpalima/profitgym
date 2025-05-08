@extends('layouts.app')

@section('content')
    <section class="team-section team-page spad set-bg" data-setbg="{{ asset('img/banner-bg.jpg') }}">
        <div class="bg-overlay"></div>
        @livewire('membership-checkout', ['membershipId' => $membership->id])
    </section>
@endsection
