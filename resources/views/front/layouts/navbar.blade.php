<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
  <div class="container">
    <!-- ===== LOGO ===== -->
    <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
      <img src="{{ asset('build/front/assets/images/logo.png') }}" alt="Research Repository Logo" width="40" height="40" class="me-2">
      <span class="text-dark">Research Repository</span>
    </a>

    <!-- ===== TOGGLER ===== -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- ===== MENU ITEMS ===== -->
    <div class="collapse navbar-collapse justify-content-between" id="navMenu">
      <!-- ===== NAV LINKS ===== -->
      <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item"><a href="{{ url('/') }}" class="nav-link text-dark active">Home</a></li>
        <li class="nav-item"><a href="{{ route('front.browse') }}" class="nav-link text-dark">Browse</a></li>
        <li class="nav-item"><a href="{{route('front.about') }}" class="nav-link text-dark">About Us</a></li>
        <li class="nav-item"><a href="{{ route('front.contact') }}" class="nav-link text-dark">Contact</a></li>
      </ul>

      <!-- ===== LOGIN / SIGNUP BUTTONS ===== -->
      <div class="d-flex align-items-center">
        <a href="{{ route('login') }}" class="btn btn-primary-custom rounded-pill px-4 me-2">
          Login
        </a>
        <a href="{{ route('register') }}" class="btn btn-success rounded-pill px-4">
          Sign Up
        </a>
      </div>
    </div>
  </div>
</nav>
