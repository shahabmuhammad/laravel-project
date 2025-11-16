@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header text-white text-center" style="background-color:#066187; font-size:1.5rem;">
                    Forgot Password
                </div>

                <div class="card-body p-4">
                    <p class="text-center fw-bold text-muted mb-4">Enter your email to reset your password</p>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold" style="background-color:#066187; border-color:#066187;">
                                Email Password Reset Link
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center text-muted">
                    Remembered your password? <a href="{{ route('login') }}" style="color:#066187;">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
