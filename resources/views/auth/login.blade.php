@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">

                {{-- Header --}}
                <div class="card-header text-white text-center" style="background-color: #066187; font-size: 1.5rem;">
                    Login Form
                </div>
            

                {{-- Body --}}
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input id="password" type="password" name="password" required
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="remember">Remember Me</label>
                        </div>

                     {{-- buttons --}}
                        <div class="d-flex justify-content-center">
    <button type="submit" class="btn btn-sm btn-primary fw-bold me-2" style="background-color:#066187; border-color:#066187; padding: 0.45rem 1.2rem;">
        Login
    </button>

    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="btn btn-sm btn-outline-primary fw-bold forgot-btn" style="color:#05374d; border-color:#043d55; padding: 0.45rem 1.2rem;">
            Forgot Password?
        </a>
    @endif
</div>

                    </form>
                </div>

                {{-- Footer --}}
                <div class="card-footer text-center text-muted">
                    Don't have an account? <a href="{{ route('register') }}" style="color:#066187;">Register now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
