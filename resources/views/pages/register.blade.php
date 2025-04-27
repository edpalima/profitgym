@extends('layouts.app')

@section('content')
    <section class="team-section team-page spad set-bg " data-setbg="{{ asset('img/breadcrumb-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <div>
            <livewire:auth.register />
        </div>
    </section>
@endsection
