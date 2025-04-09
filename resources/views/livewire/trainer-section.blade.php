<section class="team-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="team-title">
                    <div class="section-title">
                        <span>Our Team</span>
                        <h2>TRAIN WITH EXPERTS</h2>
                    </div>
                    <a href="#" class="primary-btn btn-normal appoinment-btn">appointment</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="ts-slider owl-carousel">
                @foreach($trainers as $trainer)
                    <div class="col-lg-4">
                        <div class="ts-item set-bg" data-setbg="{{ asset('storage/' . $trainer->image) }}">
                            <div class="ts_text">
                                <h4>{{ $trainer->first_name }} {{ $trainer->last_name }}</h4>
                                <span>{{ $trainer->specialization }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
