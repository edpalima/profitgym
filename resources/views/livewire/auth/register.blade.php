<section class="gradient-custom py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card text-white shadow-lg border-0" style="border-radius: 1rem; background-color: rgba(33, 37, 41, 0.7); backdrop-filter: blur(5px);">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <img src="{{ asset('logos/profit-gym.png') }}" alt="Logo" class="mb-4" style="width: 120px;">
                            <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">Create an Account</h2>
                            <p class="text-muted">Please fill in the details to register</p>
                        </div>

                        <form wire:submit.prevent="register">
                            {{-- Row 1 --}}
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input wire:model.defer="first_name" type="text" class="form-control shadow-sm">
                                    @error('first_name')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Middle Name</label>
                                    <input wire:model.defer="middle_name" type="text" class="form-control shadow-sm">
                                    @error('middle_name')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input wire:model.defer="last_name" type="text" class="form-control shadow-sm">
                                    @error('last_name')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Row 2 --}}
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input wire:model.defer="phone_number" type="text" class="form-control shadow-sm">
                                    @error('phone_number')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Birth Date</label>
                                    <input wire:model.defer="birth_date" type="date" class="form-control shadow-sm">
                                    @error('birth_date')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea wire:model.defer="address" class="form-control shadow-sm" rows="2"></textarea>
                                    @error('address')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Row 3 --}}
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Email</label>
                                    <input wire:model.defer="email" type="email" class="form-control shadow-sm">
                                    @error('email')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Password</label>
                                    <input wire:model.defer="password" type="password" class="form-control shadow-sm">
                                    @error('password')
                                        <span class="text-danger fst-italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input wire:model.defer="password_confirmation" type="password" class="form-control shadow-sm">
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-outline-light px-5" style="border-color: #f36100; color: #f36100;">
                                    Register
                                </button>
                            </div>

                            <p class="mt-4 mb-0 text-center text-muted">
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
