<section class="gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card text-white" style="border-radius: 1rem; background-color: rgba(33, 37, 41, 0.658);">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <!-- Success Message -->
                            @if (session()->has('success'))
                                <div class="alert alert-success text-center mt-3" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <!-- Error Message -->
                            @if (session()->has('error'))
                                <div class="alert alert-danger text-center mt-3" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="section-title">
                                <h2>Sign In</h2>
                            </div>
                            <p class="text-white-50 mb-5">Please enter your email and password!</p>

                            <form wire:submit.prevent="login">
                                <!-- Email Input -->
                                <div class="form-outline form-white mb-3">
                                    <input type="email" wire:model.defer="email" id="typeEmailX"
                                        class="form-control form-control-lg" />
                                    <label class="form-label" for="typeEmailX">Email</label>
                                    @error('email')
                                        : <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password Input -->
                                <div x-data="{ show: false }" class="form-outline form-white mb-4">
                                    <div class="d-flex align-items-center position-relative">
                                        <input :type="show ? 'text' : 'password'" wire:model.defer="password"
                                            id="typePasswordX" class="form-control form-control-lg pr-5" />
                                        <button type="button" class="btn btn-dark ms-2" @click="show = !show">
                                            <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                        </button>
                                    </div>
                                    <label class="form-label" for="typePasswordX">Password</label>
                                    @error('password')
                                        : <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="form-check mb-4">
                                    <input type="checkbox" wire:model="remember" class="form-check-input"
                                        id="rememberMe" />
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>

                                <!-- Login Button -->
                                <button class="btn btn-outline-light btn-lg px-5" type="submit"
                                    style="border-color: #f36100; color: #f36100;">
                                    Login
                                </button>
                            </form>

                            <!-- Sign Up Link -->
                            <div>
                                <p class="mt-4 mb-0 text-center text-muted">Don't have an account?
                                    <a href="/register" class="" style="color: #f36100">Sign Up</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
