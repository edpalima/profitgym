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
<section class="team-section team-page spad" style="background-color: rgba(0, 0, 0, 0.8);">
    <div class="container">
        <div class="row g-4">
            <!-- Personal Info -->
            <div class="col-lg-8">
                <div class="card p-4">
                    <h5>Personal Information</h5>
                    <p class="text-muted small">Your profile details and contact information</p>
                    <div class="d-flex align-items-center mb-4">
                        <div class="profile-icon me-3">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ auth()->user()->fullName }}</h5>
                            <small class="text-muted">{{ ucfirst(auth()->user()->role ?? 'Member') }}</small>
                            <div class="mt-1">
                                @if (auth()->user()->hasActiveMembership())
                                    <span class="badge bg-success">Active</span>
                                @elseif (auth()->user()->hasUpcomingApprovedMembership())
                                    <span class="badge bg-info text-dark">Upcoming</span>
                                @elseif (auth()->user()->hasPendingMembership())
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif (auth()->user()->hasExpiredMembership())
                                    <span class="badge bg-secondary">Expired</span>
                                @else
                                    <span class="badge bg-secondary">None</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Email Address</p>
                            <p><i class="bi bi-envelope"></i> {{ auth()->user()->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Contact Number</p>
                            <p><i class="bi bi-telephone"></i> {{ auth()->user()->phone_number ?? 'Not Provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Address</p>
                            <p><i class="bi bi-geo-alt"></i> {{ auth()->user()->address ?? 'Not Provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Date of Birth</p>
                            <p><i class="bi bi-calendar-heart"></i> {{ auth()->user()->birth_date }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Weight</p>
                            <p><i class="bi bi-speedometer2"></i> {{ auth()->user()->weight }}{{ auth()->user()->weight_unit }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Height</p>
                            <p><i class="bi bi-arrows-collapse-vertical"></i> {{ auth()->user()->height }}{{ auth()->user()->height_unit }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Joined Date</p>
                            <p><i class="bi bi-calendar"></i> {{ auth()->user()->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                    @if ($latestMembership = auth()->user()->latestMembership())
                        <a class="btn btn-dark mt-2" data-bs-toggle="collapse" href="#membershipInfo" role="button" aria-expanded="false" aria-controls="membershipInfo">
                            <i class="bi bi-box-arrow-up-right"></i> Membership Information
                        </a>
                        <div class="collapse mt-3" id="membershipInfo">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $latestMembership->membership->name }}</td>
                                            <td>{{ $latestMembership->membership->description }}</td>
                                            <td>{{ \Carbon\Carbon::parse($latestMembership->start_date)->format('F d, Y') }}</td>
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
                                                    <span class="badge bg-secondary">Expired</span>
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

            <!-- Member Stats -->
            <div class="col-lg-4">
                <div class="card p-4">
                    <h5>Member Stats</h5>
                    <p class="text-muted small">Your membership statistics and progress</p>
                    <div class="mb-2">
                        <p class="mb-1 fw-bold">Member Level <span class="float-end">3</span></p>
                        <div class="progress">
                            <div class="progress-bar bg-dark" style="width: 75%;"></div>
                        </div>
                        <small class="text-muted">75% to level 4</small>
                    </div>
                    <p class="mt-3 mb-1">Points Earned <span class="badge bg-light text-dark ms-2">1250</span></p>
                    <p>Active Days <span class="badge bg-light text-success ms-2">45</span></p>
                    <div class="mt-3">
                        <h6>Benefits Overview</h6>
                        <ul class="list-unstyled benefits-list">
                            <li><i class="bi bi-check-circle-fill"></i> Exclusive Content Access</li>
                            <li><i class="bi bi-check-circle-fill"></i> Priority Customer Support</li>
                            <li><i class="bi bi-check-circle-fill"></i> Dedicated Account Manager</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
