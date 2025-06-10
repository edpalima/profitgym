@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #121212;
    }
    .membership-card {
        background-color: #1f1f1f;
        border: none;
        color: #fff;
        box-shadow: 0 0 25px rgba(255, 165, 0, 0.3);
        border-radius: 16px;
        padding: 2rem;
    }
    .card-header {
        background-color: #ff6600;
        color: #fff;
        font-weight: bold;
        font-size: 2rem;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        text-align: center;
        padding: 1.5rem;
    }
    .membership-section h4 {
        color: #ff9900;
        font-size: 1.5rem;
        margin-top: 1.5rem;
    }
    .membership-section p {
        font-size: 1.2rem;
        color: #ccc;
    }
    .btn-primary {
        background-color: #ff6600;
        border: none;
        font-size: 1.2rem;
        padding: 0.75rem;
    }
    .btn-primary:hover {
        background-color: #e65c00;
    }
    .btn-secondary {
        background-color: #333;
        border: 1px solid #555;
        color: #fff;
        font-size: 1.2rem;
        padding: 0.75rem;
    }
    .btn-secondary:hover {
        background-color: #444;
    }
</style>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row justify-content-center w-100">
        <div class="col-lg-6 col-md-8">
            <div class="card membership-card">
                <div class="card-header">
                    Upgrade Your Membership
                </div>

                <div class="card-body membership-section">
                    @if($currentMembership && $currentMembership->membership)
                        <h4>Current Membership</h4>
                        <p><strong>Type:</strong> {{ $currentMembership->membership->name }}</p>
                        <p><strong>Price:</strong> ₱{{ number_format($currentMembership->membership->price, 2) }}</p>
                        <p><strong>Expires:</strong> {{ \Carbon\Carbon::parse($currentMembership->end_date)->format('M d, Y') }}</p>
                    @endif

                    <hr style="border-top: 1px solid #ff9900;">

                    <h4>New Membership</h4>
                    <p><strong>Type:</strong> {{ $newMembership->name }}</p>
                    <p><strong>Price:</strong> ₱{{ number_format($newMembership->price, 2) }}</p>
                    <p><strong>Duration:</strong> {{ $newMembership->duration_value }} {{ strtolower($newMembership->duration_unit) }}</p>

                    <form action="{{ route('membership.processUpgrade') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="new_membership_id" value="{{ $newMembership->id }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary w-100">
                                    Confirm Upgrade
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('memberships.index') }}" class="btn btn-secondary w-100">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
