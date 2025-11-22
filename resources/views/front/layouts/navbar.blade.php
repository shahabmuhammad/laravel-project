<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
    <div class="container">
        <!-- ===== LOGO ===== -->
        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
            <img src="{{ asset('build/front/assets/images/logo.png') }}" alt="Research Repository Logo" width="40"
                height="40" class="me-2" loading="lazy">
            <span class="text-dark">Research Repository</span>
        </a>

        <!-- ===== TOGGLER ===== -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
            aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- ===== MENU ITEMS ===== -->
        <div class="collapse navbar-collapse" id="navMenu">
            <!-- ===== NAV LINKS ===== -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link text-dark {{ request()->is('/') ? 'active' : '' }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.browse') }}"
                        class="nav-link text-dark {{ request()->routeIs('front.browse') ? 'active' : '' }}">
                        Browse
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.about') }}"
                        class="nav-link text-dark {{ request()->routeIs('front.about') ? 'active' : '' }}">
                        About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.contact') }}"
                        class="nav-link text-dark {{ request()->routeIs('front.contact') ? 'active' : '' }}">
                        Contact
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a href="{{ route('front.activity.index') }}"
                            class="nav-link text-dark {{ request()->routeIs('front.activity.index') ? 'active' : '' }}">
                            <i class="bi bi-activity me-1"></i>My Activity
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('front.bookmark.index') }}"
                            class="nav-link text-dark {{ request()->routeIs('front.bookmark.index') ? 'active' : '' }}">
                            <i class="bi bi-bookmark-fill me-1"></i>Bookmarks
                        </a>
                    </li>
                @endauth
            </ul>

            <!-- ===== LOGIN / SIGNUP OR USER DROPDOWN ===== -->
            <div
                class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-2 mt-3 mt-lg-0 ms-lg-3">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary-custom rounded-pill px-4">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-person-plus me-1"></i> Sign Up
                    </a>
                @else
                    <div class="dropdown">
                        <a class="btn btn-outline-primary rounded-pill px-4 dropdown-toggle" href="#" role="button"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('front.activity.index') }}">
                                    <i class="bi bi-activity me-2"></i>My Activity
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('front.bookmark.index') }}">
                                    <i class="bi bi-bookmark-fill me-2"></i>My Bookmarks
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
