@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header text-white text-center" style="background-color:#066187; font-size:1.5rem;">
                    Confirm Password
                </div>

                <div class="card-body p-4">
                    <p class="text-center fw-bold text-muted mb-4">This is a secure area. Please confirm your password before continuing.</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" id="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold" style="background-color:#066187; border-color:#066187;">Confirm</button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center text-muted">
                    <a href="{{ route('login') }}" style="color:#066187;">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
