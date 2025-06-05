@extends('layouts.app')

@section('content')
    <section class="team-section team-page spad set-bg " data-setbg="{{ asset('img/breadcrumb-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <livewire:auth.login />
    </section>  
@endsection
