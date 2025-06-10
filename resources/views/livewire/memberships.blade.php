<div>
    <section class="pricing-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        @if (session()->has('success-member'))
                            <div class="alert alert-success">{{ session('success-member') }}</div>
                        @endif
                        <span>Our Plan</span>
                        <h2>Choose your pricing plan</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($memberships as $membership)
                    <div class="col-lg-4 col-md-8">
                        <div class="ps-item">
                            <h3>{{ $membership->name }}</h3>
                            <div class="pi-price">
                                <h2>&#8369;{{ $membership->price }}</h2>
                                <span>{{ strtoupper($membership->duration_value . ' ' . $membership->duration_unit) }}</span>
                            </div>
                            <ul>
                                <li>{{ $membership->description ?? 'No description available' }}</li>
                            </ul>
                            
                            @auth
                                @if(auth()->user()->hasActiveMembership($membership->id))
                                    <button class="primary-btn pricing-btn" disabled>Current Plan</button>
                                @elseif(auth()->user()->hasActiveMembership())
                                    @if(auth()->user()->canUpgradeTo($membership->id))
                                        <a href="{{ route('membership.upgrade', $membership->id) }}" 
                                           class="primary-btn pricing-btn upgrade-btn">Upgrade Now</a>
                                    @else
                                        <button class="primary-btn pricing-btn" disabled>Not Available</button>
                                    @endif
                                @else
                                    @if(auth()->user()->hasPendingMembership())
                                        <button class="primary-btn pricing-btn" disabled>Pending Approval</button>
                                    @else
                                        <a href="{{ route('membership.checkout', $membership->id) }}" 
                                           class="primary-btn pricing-btn">Enroll now</a>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('membership.checkout', $membership->id) }}" 
                                   class="primary-btn pricing-btn">Enroll now</a>
                            @endauth
                            
                            <a href="{{ route('membership.checkout', $membership->id) }}" class="thumb-icon">
                                <i class="fa fa-picture-o"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if (Route::is('memberships.index'))
        @auth
            @if (auth()->user()->role === 'MEMBER')
                <livewire:feedback-form />
            @else
                <p class="text-center mt-4">
                    You want to submit feedback? Please
                    <a href="{{ route('login') }}" class="color-primary">log in</a> as a MEMBER to provide feedback.
                </p>
            @endif
        @else
            <p class="text-center mt-4">
                You want to submit feedback? Please
                <a href="{{ route('login') }}" class="color-primary">log in</a> to provide feedback.
            </p>
        @endauth
    @endif

    <style>
        .upgrade-btn {
            background-color: #4CAF50;
            margin-top: 10px;
        }
        .upgrade-btn:hover {
            background-color: #45a049;
        }
        .ps-item button[disabled] {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
</div>