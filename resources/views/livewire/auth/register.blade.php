<section class="gradient-custom py-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-10">
                <div class="card text-white shadow-lg border-0"
                    style="border-radius: 1rem; background-color: rgba(33, 37, 41, 0.7); backdrop-filter: blur(5px);">
                    <div class="leave-comment card-body p-4">
                        <div class="text-center mb-4">
                            <img src="{{ asset('logos/profit-gym.png') }}" alt="Logo" class="mb-3"
                                style="width: 100px;">
                            <h3 class="fw-bold text-uppercase" style="letter-spacing: 1px;">Create an Account</h3>
                            <p class="text-muted">Please fill in the details to register</p>
                        </div>

                        <form wire:submit.prevent="register">

                            {{-- Section: Personal Information --}}
                            <h5 class="text-uppercase mb-3">Personal Information</h5>
                            <hr class="mb-3" style="border-top: 1px solid #6c757d;">

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input wire:model.defer="first_name" type="text"
                                        class="form-control form-control-sm">
                                    @error('first_name')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Middle Name</label>
                                    <input wire:model.defer="middle_name" type="text"
                                        class="form-control form-control-sm">
                                    @error('middle_name')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input wire:model.defer="last_name" type="text"
                                        class="form-control form-control-sm">
                                    @error('last_name')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Section: Contact Information --}}
                            <h5 class="text-uppercase mt-4 mb-3">Contact Information</h5>
                            <hr class="mb-3" style="border-top: 1px solid #6c757d;">

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input wire:model.defer="phone_number" type="text"
                                        class="form-control form-control-sm">
                                    @error('phone_number')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Birth Date</label>
                                    <input wire:model.defer="birth_date" type="date"
                                        class="form-control form-control-sm">
                                    @error('birth_date')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea wire:model.defer="address" class="form-control form-control-sm" rows="2"></textarea>
                                    @error('address')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Section: Physical Information --}}
                            <h5 class="text-uppercase mt-4 mb-3">Physical Information</h5>
                            <hr class="mb-3" style="border-top: 1px solid #6c757d;">

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Weight (kg)</label>
                                    <input wire:model.defer="weight" type="number" step="0.1"
                                        class="form-control form-control-sm">
                                    @error('weight')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Height (cm)</label>
                                    <input wire:model.defer="height" type="number" step="0.1"
                                        class="form-control form-control-sm">
                                    @error('height')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Section: Security --}}
                            <h5 class="text-uppercase mt-4 mb-3">Credential</h5>
                            <hr class="mb-3" style="border-top: 1px solid #6c757d;">

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Email</label>
                                    <input wire:model.defer="email" type="email" class="form-control form-control-sm">
                                    @error('email')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Password</label>
                                    <div x-data="{ show: false }" class="d-flex align-items-center position-relative">
                                        <input :type="show ? 'text' : 'password'" wire:model.defer="password"
                                            class="form-control form-control-sm pr-5" />
                                        {{-- <button style="border-width:0; border-radius:0;" type="button"
                                            class="btn btn-dark ms-2" @click="show = !show">
                                            <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                        </button> --}}
                                    </div>
                                    @error('password')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div x-data="{ show: false }" class="d-flex align-items-center position-relative">
                                        <input :type="show ? 'text' : 'password'"
                                            wire:model.defer="password_confirmation"
                                            class="form-control form-control-sm pr-5" />
                                        {{-- <button style="" type="button"
                                            class="btn btn-dark top-0 end-0 translate-middle-y" @click="show = !show">
                                            <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                        </button> --}}
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Register
                                </button>
                            </div>

                            <p class="mt-3 mb-0 text-center text-muted">
                                Already have an account?
                                <a href="/login" class="fw-semibold primary-color">Login</a>
                            </p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
