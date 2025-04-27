@extends('layouts.app')

@section('content')
    <!-- Banner -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/banner-bg.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb-text text-center text-white">
                        <h2>Account</h2>
                        <div class="bt-option">
                            <a href="{{ url('/') }}">Home</a>
                            <span>Account</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Account Info -->
    <section class="team-section team-page spad">
        <div class="container">
            <div class="row mb-5">
                <!-- Profile Information -->
                <div class="col-lg-12 mb-4">
                    <div class="section-title">
                        <h2>Profile</h2>
                    </div>
                    <div class="chart-table">
                        <table class="table table-bordered mb-0">
                            <tr>
                                <td>Name</td>
                                <td>{{ auth()->user()->fullName }}</td>
                            <tr>
                                <td>Email</td>
                                <td>{{ auth()->user()->email }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ auth()->user()->address ?? 'Not Provided' }}</td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td>{{ auth()->user()->phone_number ?? 'Not Provided' }}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>{{ auth()->user()->birth_date }}</td>
                            </tr>
                            <tr>
                                <td>Weight</td>
                                <td>{{ auth()->user()->weight }}{{ auth()->user()->weight_unit }}</td>
                            </tr>
                            <tr>
                                <td>Height</td>
                                <td>{{ auth()->user()->height }}{{ auth()->user()->height_unit }}</td>
                            </tr>
                            <tr>
                                <td>Role</td>
                                <td>{{ ucfirst(auth()->user()->role ?? 'Member') }}</td>
                            </tr>
                            <tr>
                                <td>Joined</td>
                                <td>{{ auth()->user()->created_at->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td>Membership Status</td>
                                <td>
                                    @if (auth()->user()->hasActiveMembership())
                                        <span class="badge bg-success">Active</span>
                                    @elseif (auth()->user()->hasUpcomingApprovedMembership())
                                        <span class="badge bg-info text-dark">Upcoming</span>
                                    @elseif (auth()->user()->hasPendingMembership())
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-secondary">None</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if ($latestMembership = auth()->user()->latestMembership())
                    <div class="col-lg-12 mt-5">
                        <div class="section-title">
                            <h2>Membership Information</h2>
                        </div>
                        <div class="chart-table">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Membership Type</th>
                                        <th>Description</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $latestMembership->membership->name }}</td>
                                        <td>{{ $latestMembership->membership->description }}</td>
                                        <td>{{ \Carbon\Carbon::parse($latestMembership->start_date)->format('F d, Y') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($latestMembership->end_date)->format('F d, Y') }}</td>
                                        <td>₱{{ number_format($latestMembership->membership->price, 2) }}</td>
                                        <td>
                                            @if ($latestMembership->is_active && now()->between($latestMembership->start_date, $latestMembership->end_date))
                                                <span class="badge bg-success">Active</span>
                                            @elseif ($latestMembership->status === 'APPROVED' && now()->lt($latestMembership->start_date))
                                                <span class="badge bg-info text-dark">Upcoming</span>
                                            @elseif ($latestMembership->status === 'PENDING')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
