@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/banner-bg.jpg') }}">
        <div class="bg-overlay dark-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Our Trainers</h2>
                        <div class="bt-option">
                            <a href="{{ url('/') }}">Home</a>
                            <span>Our trainers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Team Section Begin -->
    <section class="team-section team-page spad dark-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title">
                        <div class="section-title">
                            <span>Our Trainers</span>
                            <h2>TRAIN WITH EXPERTS</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($trainers as $trainer)
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="trainer-card">
                            <div class="ts-item set-bg" data-setbg="{{ asset('storage/' . $trainer->image) }}">
                                <div class="ts_text">
                                    <h4>{{ $trainer->first_name }} {{ $trainer->last_name }}</h4>
                                    <span>{{ $trainer->specialization }}</span>
                                </div>
                            </div>
                            <div class="trainer-info">
                                <div class="specialization">{{ strtoupper($trainer->specialization) }}</div>
                                <div class="rating">
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($trainer->average_rating ?? 4.9))
                                                <i class="fa fa-star"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-text">({{ $trainer->reviews_count ?? '89' }} reviews)</span>
                                </div>
                                <div class="contact">
                                    <div class="email"><i class="fa fa-envelope"></i> {{ $trainer->email }}</div>
                                    <div class="phone"><i class="fa fa-phone"></i> {{ $trainer->phone }}</div>
                                </div>
                                <div class="experience">
                                    {{ $trainer->years_of_experience ?? '7' }} years of experience teaching {{ $trainer->specialization }}, 
                                    focusing on mindfulness, flexibility, and mental well-being
                                </div>
                                <div class="actions">
                                    <button class="view-details-btn" data-toggle="modal" data-target="#trainerModal-{{ $trainer->id }}">
                                        <i class="fa fa-info-circle"></i> View Details & Schedule
                                    </button>
                                    <button class="rate-feedback-btn" data-toggle="modal" data-target="#rateFeedbackModal-{{ $trainer->id }}">
                                        <i class="fa fa-star"></i> Rate & Feedback
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trainer Details Modal (XL Size) -->
                    <div class="modal fade" id="trainerModal-{{ $trainer->id }}" tabindex="-1" role="dialog" aria-labelledby="trainerModalLabel-{{ $trainer->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content dark-modal">
                                <div class="modal-header orange-bg">
                                    <h5 class="modal-title" id="trainerModalLabel-{{ $trainer->id }}">{{ $trainer->first_name }} {{ $trainer->last_name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <img src="{{ asset('storage/' . $trainer->image) }}" class="img-fluid mb-3 trainer-modal-img" alt="{{ $trainer->first_name }}">
                                            <div class="trainer-contact-info">
                                                <h5 class="orange-text">Contact Information</h5>
                                                <p><i class="fa fa-envelope orange-text"></i> <strong>Email:</strong> {{ $trainer->email }}</p>
                                                <p><i class="fa fa-phone orange-text"></i> <strong>Phone:</strong> {{ $trainer->phone }}</p>
                                                <p><i class="fa fa-clock-o orange-text"></i> <strong>Experience:</strong> {{ $trainer->years_of_experience ?? '7' }} years</p>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <h4 class="orange-text">About {{ $trainer->first_name }}</h4>
                                            <p class="trainer-bio">{{ $trainer->bio ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor.' }}</p>
                                            
                                            <h4 class="orange-text mt-4">Specialization</h4>
                                            <p>{{ $trainer->specialization }}</p>
                                            
                                            <h4 class="orange-text mt-4">Schedule</h4>
                                            <div class="table-responsive">
                                                <table class="table table-dark schedule-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Day</th>
                                                            <th>Time</th>
                                                            <th>Class</th>
                                                            <th>Availability</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($trainer->schedules as $schedule)
                                                            <tr>
                                                                <td>{{ $schedule->day }}</td>
                                                                <td>{{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</td>
                                                                <td>{{ $schedule->class_type }}</td>
                                                                <td>
                                                                    @if($schedule->availability === 'Available')
                                                                        <span class="badge badge-success">Available</span>
                                                                    @elseif($schedule->availability === 'Limited')
                                                                        <span class="badge badge-warning">Limited</span>
                                                                    @else
                                                                        <span class="badge badge-danger">Booked</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                                                                    </div>
                                    </div>
                                </div>
                                <div class="modal-footer dark-modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rate & Feedback Modal (XL Size) -->
                    <div class="modal fade" id="rateFeedbackModal-{{ $trainer->id }}" tabindex="-1" role="dialog" aria-labelledby="rateFeedbackModalLabel-{{ $trainer->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content dark-modal">
                                <div class="modal-header orange-bg">
                                <h5 class="modal-title" id="rateFeedbackModalLabel-{{ $trainer->id }}">Rate & Feedback for {{ $trainer->first_name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Replace the entire modal form with this: -->
                            <form action="{{ Auth::check() ? route('trainers.rate', $trainer->id) : '#' }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="trainer-rate-card text-center">
                                                <img src="{{ asset('storage/' . $trainer->image) }}" class="img-fluid rounded-circle mb-3 rate-trainer-img" alt="{{ $trainer->first_name }}">
                                                <h4>{{ $trainer->first_name }} {{ $trainer->last_name }}</h4>
                                                <p class="text-muted">{{ $trainer->specialization }}</p>
                                                <div class="current-rating mb-3">
                                                    <h5>Current Rating</h5>
                                                    <div class="stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= ($trainer->average_rating ?? 4.9))
                                                                <i class="fa fa-star"></i>
                                                            @else
                                                                <i class="fa fa-star-o"></i>
                                                            @endif
                                                        @endfor
                                                        <span>({{ $trainer->reviews_count ?? '89' }} reviews)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @guest
                                                <div class="alert alert-warning">
                                                    <p>Please <a href="{{ route('login') }}">login</a> to submit your feedback.</p>
                                                </div>
                                            @endguest
                                            <div class="form-group">
                                                <label for="rating-{{ $trainer->id }}">Your Rating</label>
                                                <div class="rating-stars text-center">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <input type="radio" id="star{{ $i }}-{{ $trainer->id }}" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} {{ Auth::guest() ? 'disabled' : '' }}>
                                                        <label for="star{{ $i }}-{{ $trainer->id }}"><i class="fa fa-star"></i></label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="feedback-{{ $trainer->id }}">Your Feedback</label>
                                                <textarea class="form-control dark-input" id="feedback-{{ $trainer->id }}" name="feedback" rows="5" placeholder="Share your experience with {{ $trainer->first_name }}..." {{ Auth::guest() ? 'disabled' : '' }}></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Would you recommend this trainer?</label>
                                                <div class="recommend-options">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="recommend" id="recommend-yes-{{ $trainer->id }}" value="1" checked {{ Auth::guest() ? 'disabled' : '' }}>
                                                        <label class="form-check-label" for="recommend-yes-{{ $trainer->id }}">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="recommend" id="recommend-no-{{ $trainer->id }}" value="0" {{ Auth::guest() ? 'disabled' : '' }}>
                                                        <label class="form-check-label" for="recommend-no-{{ $trainer->id }}">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer dark-modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn orange-btn" {{ Auth::guest() ? 'disabled' : '' }}>Submit Feedback</button>
                                    @guest
                                        <a href="{{ route('login') }}" class="btn orange-btn ml-2">Login to Rate</a>
                                    @endguest
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <style>
        :root {
            --orange: #FF7F00;
            --orange-dark: #cc6600;
            --dark-bg: #2a2a2a;
            --darker-bg: #1f1f1f;
            --card-bg: #333;
            --text-light: #f8f9fa;
            --text-muted: #FFFFFF;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-light);
        }

        .dark-bg {
            background-color: var(--dark-bg);
        }

        .dark-overlay {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .trainer-card {
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: transform 0.3s ease;
            color: var(--text-light);
        }
        
        .trainer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.4);
        }
        
        .trainer-info {
            padding: 20px;
        }
        
        .specialization {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: var(--orange);
        }
        
        .rating {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .stars {
            color: var(--orange);
            margin-right: 8px;
        }

        .stars .fa-star {
            margin-right: 2px;
        }

        .rating-text {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .contact div {
            margin-bottom: 8px;
            color: var(--text-light);
        }

        .contact i {
            color: var(--orange);
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }
        
        .experience {
            margin: 15px 0;
            color: var(--text-light);
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .actions {
            border-top: 1px solid #444;
            padding-top: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .view-details-btn, .rate-feedback-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .view-details-btn {
            background-color: var(--orange);
            color: white;
        }
        
        .view-details-btn:hover {
            background-color: var(--orange-dark);
            transform: translateY(-2px);
        }
        
        .rate-feedback-btn {
            background-color: transparent;
            color: var(--orange);
            border: 2px solid var(--orange);
        }
        
        .rate-feedback-btn:hover {
            background-color: rgba(255, 127, 0, 0.1);
            transform: translateY(-2px);
        }

        .view-details-btn i, .rate-feedback-btn i {
            margin-right: 8px;
        }

        /* Modal Styles */
        .dark-modal {
            background-color: var(--darker-bg);
            color: var(--text-light);
        }

        .dark-modal .modal-header {
            border-bottom: 1px solid #444;
        }

        .dark-modal .modal-footer {
            border-top: 1px solid #444;
        }

        .orange-bg {
            background-color: var(--orange);
            color: white;
        }

        .orange-text {
            color: var(--orange);
        }

        .trainer-modal-img {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        .trainer-contact-info {
            background: var(--card-bg);
            padding: 15px;
            border-radius: 8px;
        }

        .trainer-contact-info i {
            margin-right: 10px;
        }

        .trainer-bio {
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .schedule-table {
            background-color: var(--card-bg);
        }

        .schedule-table th {
            background-color: #444;
            color: var(--orange);
        }

        .schedule-table td {
            vertical-align: middle;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .dark-input {
            background-color: #444;
            border-color: #555;
            color: var(--text-light);
        }

        .dark-input:focus {
            background-color: #555;
            color: var(--text-light);
            border-color: var(--orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 127, 0, 0.25);
        }

        .orange-btn {
            background-color: var(--orange);
            color: white;
            border: none;
        }

        .orange-btn:hover {
            background-color: var(--orange-dark);
            color: white;
        }

        /* Rate & Feedback Modal Specific Styles */
        .rate-trainer-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 3px solid var(--orange);
        }

        .trainer-rate-card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 8px;
            height: 100%;
        }

        .current-rating {
            padding: 10px;
            background: rgba(0,0,0,0.2);
            border-radius: 8px;
        }

        /* Star Rating Input */
        .rating-stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            margin: 20px 0;
        }

        .rating-stars input {
            display: none;
        }

        .rating-stars label {
            color: #ddd;
            font-size: 36px;
            padding: 0 10px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .rating-stars input:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: var(--orange);
        }

        .recommend-options {
            margin-top: 15px;
        }

        .form-check-input:checked {
            background-color: var(--orange);
            border-color: var(--orange);
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Check if we need to show a rate modal after login
            @if(session('show_rate_modal'))
                $('#rateFeedbackModal-{{ session('show_rate_modal') }}').modal('show');
            @endif

            // Rest of your existing script
        });

        $(document).ready(function() {
            // Initialize modals
            $('.modal').modal();

            // Star rating interaction
            $('.rating-stars input').change(function() {
                const rating = $(this).val();
                console.log('Rating selected:', rating);
            });

            // Smooth scroll for modals
            $('.modal').on('shown.bs.modal', function() {
                $(this).animate({ scrollTop: 0 }, 'slow');
            });
        });
    </script>
@endsection