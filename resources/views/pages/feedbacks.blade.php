@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/banner-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Feedbacks</h2>
                        <div class="bt-option">
                            <a href="{{ url('/') }}">Home</a>
                            <span>My Feedbacks</span>
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
                            <span>My Feedbacks</span>
                        </div>
                        {{-- <a href="#" class="primary-btn btn-normal appoinment-btn">appointment</a> --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="chart-table">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Membership</th>
                                <th>Message</th>
                                <th>Rating</th>
                                <th>Is Approved</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->membership?->name ?? 'No Membership' }}</td>
                                    <td>{{ Str::limit($feedback->message, 100) }}</td>
                                    <td>
                                        @for ($i = 0; $i < $feedback->rating; $i++)
                                            <i class="fa fa-star text-warning"></i>
                                        @endfor
                                        @for ($i = $feedback->rating; $i < 5; $i++)
                                            <i class="fa fa-star-o text-muted"></i>
                                        @endfor
                                    </td>
                                    <td>{{ $feedback->is_approved ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <form action="#" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No feedback available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->
@endsection
