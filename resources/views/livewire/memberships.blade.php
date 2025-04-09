<section class="pricing-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Our Plan</span>
                    <h2>Choose your pricing plan</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($memberships as $membership)
                <div class="col-lg-4 col-md-8">
                    <div class="ps-item">
                        <h3>{{ $membership->name }}</h3>
                        <div class="pi-price">
                            <h2>&#8369;{{ $membership->price }}</h2>
                            <span>{{ strtoupper($membership->duration_value . ' ' . $membership->duration_unit) }}</span>
                        </div>
                        <ul>
                            <li>{{ $membership->description ?? 'No description available' }}</li>
                            <!-- You can add more membership features here if needed -->
                        </ul>
                        <a href="#" class="primary-btn pricing-btn">Enroll now</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>