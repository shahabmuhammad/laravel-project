@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center align-items-center ">
            <div class="col-11 col-md-10 col-lg-8 col-xl-7">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                    {{-- Header with gradient --}}
                    <div class="card-header text-white text-center py-4 border-0"
                        style="background: linear-gradient(135deg, #066187 0%, #054e6a 100%);">
                        <div class="mb-3">
                            <i class="bi bi-person-plus-fill" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mb-0 fw-bold">Create Your Account</h4>
                        <p class="mb-0 small opacity-90">Join our research repository community</p>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row ">
                                {{-- Name --}}
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-person me-2" style="color: #066187;"></i>Full Name
                                    </label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                        autofocus class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        placeholder="Enter your full name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-envelope me-2" style="color: #066187;"></i>Email Address
                                    </label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        placeholder="Enter your email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-lock me-2" style="color: #066187;"></i>Password
                                    </label>
                                    <input id="password" type="password" name="password" required
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="Create a password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-lock-fill me-2" style="color: #066187;"></i>Confirm Password
                                    </label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required
                                        class="form-control form-control-lg" placeholder="Re-enter your password">
                                </div>

                                {{-- Role / Type --}}
                                <div class="col-12">
                                    <label for="type" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-person-badge me-2" style="color: #066187;"></i>Select Your Profile
                                    </label>
                                    <select id="type" name="type"
                                        class="form-select form-select-lg @error('type') is-invalid @enderror" required>
                                        <option value="" selected disabled>Choose your profile type</option>
                                        <option value="User">Student</option>
                                        <option value="Author">Research Author</option>
                                        <option value="Admin">Administrator</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Register Button --}}
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-lg fw-semibold text-white py-3"
                                    style="background: linear-gradient(135deg, #066187 0%, #054e6a 100%); border: none;">
                                    <i class="bi bi-check-circle me-2"></i>Create Account
                                </button>
                            </div>

                        </form>
                    </div>

                    {{-- Footer --}}
                    <div class="card-footer text-center py-3 bg-light border-0">
                        <p class="mb-0 small text-muted">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color:#066187;">
                                Sign In
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
