@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg position-relative" data-setbg="{{ asset('img/about-us.jpg') }}">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Terms and Conditions</h2>
                        <div class="bt-option">
                            <a href="{{ url('/') }}">Home</a>
                            <span>Terms and Conditions</span>
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
                            <span>Terms and Conditions</span>
                        </div>
                        {{-- <a href="#" class="primary-btn btn-normal appoinment-btn">appointment</a> --}}
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <p>
                    By enrolling in our gym membership program, you agree to comply fully with the following terms and
                    conditions, which are designed to ensure the safety, integrity, and smooth operation of our facility.
                    Membership is available to individuals aged 18 years and older. Individuals below this age must obtain
                    verifiable parental or guardian consent and may be subject to limited access or usage hours for safety
                    reasons. All membership fees, including any promotional rates or recurring charges, must be paid in full
                    according to the plan chosen. These fees are non-refundable and non-transferable, except in
                    circumstances deemed valid by management, such as medical emergencies or facility closures beyond the
                    member’s control.
                </p>
                <p>
                    Members are expected to exhibit courteous and respectful behavior at all times. Harassment, verbal
                    abuse, or inappropriate conduct directed at other members or staff will not be tolerated and may result
                    in immediate suspension or permanent revocation of membership privileges. Proper workout attire,
                    including appropriate footwear, must be worn at all times. Personal belongings should be stored in
                    designated lockers, and the gym is not responsible for lost or stolen items left unattended in open
                    areas.
                </p>
                <p>
                    The use of gym equipment must follow the instructions and guidance provided by staff or displayed
                    signage. Members are responsible for wiping down machines and returning weights or other gear to their
                    proper places after use. Any damage to equipment caused by misuse or negligence may result in repair
                    costs being charged to the responsible party. Group classes, personal training sessions, and specialty
                    programs may require additional registration and fees, and participation is subject to availability.
                </p>
                <p>
                    All members acknowledge the inherent risks associated with physical exercise, including the possibility
                    of injury, muscle strain, or other health-related complications. It is the member’s responsibility to
                    consult with a medical professional before beginning any fitness regimen. The gym and its staff are not
                    liable for injuries sustained during the use of our facilities, whether in supervised sessions or
                    independent workouts. Emergency procedures and contact protocols are posted throughout the facility, and
                    members are encouraged to familiarize themselves with them.
                </p>
                <p>
                    We are committed to protecting your personal information. Any data collected during membership
                    registration or usage will be kept confidential and used solely for operational and communication
                    purposes. Under no circumstances will personal data be sold or shared with third parties without
                    consent, except where required by law. Members may receive newsletters, updates, or promotional content
                    via email, with the option to opt out at any time.
                </p>
                <p>
                    These terms and conditions are subject to periodic updates and revisions. Any significant changes will
                    be communicated through our official communication channels. Continued use of the gym and its services
                    after the update constitutes acceptance of the revised terms. We encourage all members to review the
                    policy regularly and contact our front desk or management team with any questions, clarifications, or
                    feedback.
                </p>
            </div>

        </div>
    </section>
    <!-- Team Section End -->
@endsection
