<section class="classes-section spad" id="workout-guides">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Our Workout Guides</span>
                    <h2>EXPLORE OUR VARIETY OF Guides</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($workoutGuides as $guide)
                @if ($loop->iteration === 4 || $loop->iteration === 5)
                <div class="col-lg-6">
                @else
                <div class="col-lg-4 col-md-6">
                @endif
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="{{ asset('storage/' . $guide->featured_photo) }}" alt="{{ $guide->title }}">
                        </div>
                        <div class="ci-text">
                            <h5>{{ $guide->title }}</h5>
                            <p class="wg-description">
                                {!! \Illuminate\Support\Str::limit(strip_tags($guide->description), 100) !!}
                            </p>
                            <a href="{{ route('workout-guide.show', $guide->id) }}"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
