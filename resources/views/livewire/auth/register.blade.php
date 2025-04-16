<section class="gradient-custom">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body p-5">
                        <h3 class="mb-4 text-center" style="color: #f36100;">Register</h3>

                        <form wire:submit.prevent="register">
                            {{-- Row 1 --}}
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>First Name</label>
                                    <input wire:model.defer="first_name" type="text" class="form-control">
                                    @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Middle Name</label>
                                    <input wire:model.defer="middle_name" type="text" class="form-control">
                                    @error('middle_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Last Name</label>
                                    <input wire:model.defer="last_name" type="text" class="form-control">
                                    @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            {{-- Row 2 --}}
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Phone Number</label>
                                    <input wire:model.defer="phone_number" type="text" class="form-control">
                                    @error('phone_number') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Birth Date</label>
                                    <input wire:model.defer="birth_date" type="date" class="form-control">
                                    @error('birth_date') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Address</label>
                                    <textarea wire:model.defer="address" class="form-control" rows="2"></textarea>
                                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            {{-- Row 3 --}}
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Email</label>
                                    <input wire:model.defer="email" type="email" class="form-control">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Password</label>
                                    <input wire:model.defer="password" type="password" class="form-control">
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Confirm Password</label>
                                    <input wire:model.defer="password_confirmation" type="password" class="form-control">
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-outline-light px-5" style="border-color: #f36100; color: #f36100;">
                                    Register
                                </button>
                            </div>

                            <p class="mt-4 mb-0 text-center">
                                Already have an account?
                                <a href="/login" style="color: #f36100;">Login</a>
                            </p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
