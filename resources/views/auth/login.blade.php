@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center align-items-center ">
            <div class="col-11 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                    {{-- Header with gradient --}}
                    <div class="card-header text-white text-center py-4 border-0"
                        style="background: linear-gradient(135deg, #066187 0%, #054e6a 100%);">
                        <div class="mb-3">
                            <i class="bi bi-shield-lock" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mb-0 fw-bold">Welcome Back</h4>
                        <p class="mb-0 small opacity-90">Sign in to your account</p>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-envelope me-2" style="color: #066187;"></i>Email Address
                                </label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    autofocus class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    placeholder="Enter your email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-lock me-2" style="color: #066187;"></i>Password
                                </label>
                                <input id="password" type="password" name="password" required
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    placeholder="Enter your password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Remember Me & Forgot Password --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="remember">Remember Me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none"
                                        style="color:#066187;">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>

                            {{-- Login Button --}}
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-lg fw-semibold text-white py-3"
                                    style="background: linear-gradient(135deg, #066187 0%, #054e6a 100%); border: none;">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                                </button>
                            </div>

                        </form>
                    </div>

                    {{-- Footer --}}
                    <div class="card-footer text-center py-3 bg-light border-0">
                        <p class="mb-0 small text-muted">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold"
                                style="color:#066187;">
                                Create Account
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
