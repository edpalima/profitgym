<section class="testimonial-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Feedback</span>
                    <h2>OUR CLIENT SAY ABOUT OUR GYM</h2>
                </div>
            </div>
        </div>
        <div class="ts_slider owl-carousel">
            @foreach ($feedbacks as $feedback)
                <div class="ts_item">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="ti_pic">
                                <img src="{{ asset('storage/' . $feedback->user->photo) }}" alt="">
                            </div>
                            <div class="ti_text">
                                <p>{{ $feedback->message }}</p>
                                <h5>{{ $feedback->user?->full_name ?? 'Anonymous' }}</h5>
                                <div class="tt-rating">
                                    @for ($i = 0; $i < $feedback->rating; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                    @for ($i = $feedback->rating; $i < 5; $i++)
                                        <i class="fa fa-star-o"></i> {{-- empty star --}}
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
