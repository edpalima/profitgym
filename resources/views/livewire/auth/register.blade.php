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
                                    <label class="form-label" for="first_name">First Name</label>
                                    <input id="first_name" wire:model.defer="first_name" type="text"
                                        class="form-control form-control-sm">
                                    @error('first_name')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="middle_name">Middle Name</label>
                                    <input id="middle_name" wire:model.defer="middle_name" type="text"
                                        class="form-control form-control-sm">
                                    @error('middle_name')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="last_name">Last Name</label>
                                    <input id="last_name" wire:model.defer="last_name" type="text"
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
                                    <label class="form-label" for="phone_number">Phone Number</label>
                                    <input id="phone_number" wire:model.defer="phone_number" type="text"
                                        class="form-control form-control-sm"
                                        pattern="^\d{11}$"
                                        placeholder="09123456789"
                                        value="09">
                                    @error('phone_number')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="birth_date">Birth Date</label>
                                    <input id="birth_date" wire:model.defer="birth_date" type="date"
                                        class="form-control form-control-sm">
                                    @error('birth_date')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea id="address" wire:model.defer="address" class="form-control form-control-sm" rows="2"></textarea>
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
                                    <label class="form-label" for="weight">Weight (kg)</label>
                                    <input id="weight" wire:model.defer="weight" type="number" step="0.1"
                                        class="form-control form-control-sm">
                                    @error('weight')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="height">Height (cm)</label>
                                    <input id="height" wire:model.defer="height" type="number" step="0.1"
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
                                    <label class="form-label" for="email">Email</label>
                                    <input id="email" wire:model.defer="email" type="email"
                                        class="form-control form-control-sm">
                                    @error('email')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <div x-data="{ show: false }" class="d-flex align-items-center position-relative">
                                        <input id="password" :type="show ? 'text' : 'password'"
                                            wire:model.defer="password" class="form-control form-control-sm pr-5" />
                                        <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"
                                        @click="show = !show"
                                        class="position-absolute"
                                        style="top: 25px; right: 10px; transform: translateY(-50%); cursor: pointer; color: #aaa;">
                                        </i>
                                    </div>
                                    @error('password')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    <div x-data="{ show: false }" class="d-flex align-items-center position-relative">
                                        <input id="password_confirmation" :type="show ? 'text' : 'password'"
                                            wire:model.defer="password_confirmation"
                                            class="form-control form-control-sm pr-5" />
                                        <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"
                                        @click="show = !show"
                                        class="position-absolute translate-middle-y"
                                        style="top: 25px; right: 10px; transform: translateY(-50%); cursor: pointer; color: #aaa;"></i>
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
