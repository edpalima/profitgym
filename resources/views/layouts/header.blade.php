<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Offcanvas Menu Section Begin -->
<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="canvas-close">
        <i class="fa fa-close"></i>
    </div>
    <div class="canvas-search search-switch">
        <i class="fa fa-search"></i>
    </div>
    <nav class="canvas-menu mobile-menu">
        <ul>
            <li><a href="/">Home</a></li>
            {{-- <li><a href="./about-us.html">About Us</a></li> --}}
            <li><a href="{{ route('memberships.index') }}">Memberships</a></li>
            <li><a href="{{ route('products') }}">Products</a></li>
            <li><a href="{{ route('home') }}#workout-guides">Workout Guide</a></li>
            <li><a href="{{ route('trainers.index') }}">Trainers</a></li>
            @if (!Auth::check() || Auth::user()->role !== \App\Models\User::ROLE_MEMBER)
                <li class="{{ Route::currentRouteName() === 'login' ? 'active' : '' }}">
                    <a href="{{ route('login') }}">Sign In</a>
                </li>
            @else
                <li><a href="{{ route('logout') }}">Logout</a></li>
                <li><a href="#">My Account</a>
                    <ul class="dropdown">
                        
                        <li><a href="{{ route('account') }}">Profile</a></li>
                        <li><a href="{{ route('orders') }}">Orders</a></li>
                        <li><a href="{{ route('feedbacks') }}">My Feedbacks</a></li>
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="canvas-social">
        <a href="https://www.facebook.com/ProfitTonesFlexes" target="_blank"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-youtube-play"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
    </div>
</div>
<!-- Offcanvas Menu Section End -->

<!-- Header Section Begin -->
<header class="header-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="logo">
                    <a href="/">
                        <img class="menu-logo" src="{{ asset('logos/profit-gym.png') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="nav-menu">
                    <ul>
                        <li class="{{ Route::currentRouteName() === 'home' ? 'active' : '' }}">
                            <a href="/">Home</a>
                        </li>
                        {{-- <li><a href="./about-us.html">About Us</a></li> --}}
                        <li class="{{ request()->routeIs('memberships.index') ? 'active' : '' }}">
                            <a href="{{ route('memberships.index') }}">Memberships</a>
                        </li>
                        <li
                            class="{{ request()->routeIs('products') || request()->routeIs('product.show') ? 'active' : '' }}">
                            <a href="{{ route('products') }}">Products</a>
                        </li>
                        <li class="{{ request()->routeIs('workout-guide.show') ? 'active' : '' }}">
                            <a href="{{ route('home') }}#workout-guides">Workout Guide</a>
                        </li>
                        <li class="{{ request()->routeIs('trainers.index') ? 'active' : '' }}">
                            <a href="{{ route('trainers.index') }}">Trainers</a>
                        </li>
                        {{-- <li><a href="./services.html">Services</a></li>
                        <li><a href="./team.html">Our Team</a></li> --}}

                        @if (!Auth::check() || Auth::user()->role !== \App\Models\User::ROLE_MEMBER)
                            <li class="{{ Route::currentRouteName() === 'login' ? 'active' : '' }}">
                                <a href="{{ route('login') }}">Sign In</a>
                            </li>
                        @else
                            <li class="{{ Route::currentRouteName() === 'account' ? 'active' : '' }}">
                                <a href="#">My Account</a>
                                <ul class="dropdown">
                                    <li><a href="{{ route('account') }}">Profile</a></li>
                                    <li><a href="{{ route('orders') }}">Orders</a></li>
                                    <li><a href="{{ route('feedbacks') }}">My Feedbacks</a></li>
                                    <li><a href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @endif

                        {{-- <li><a href="./contact.html">Contact</a></li> --}}
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="top-option">
                    <div class="to-search search-switch">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="to-social">
                        <a href="https://www.facebook.com/ProfitTonesFlexes" target="_blank"><i
                                class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="canvas-open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header End -->
