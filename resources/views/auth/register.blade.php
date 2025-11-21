@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">

                {{-- Header --}}
                <div class="card-header text-white text-center" style="background-color: #066187; font-size: 1.5rem;">
                    Registeration Form
                </div>
                {{-- <div class="text-center mt-3">
                    <h5 style="color: #066187; font-weight: 600;">Join KPTIB Research Repository</h5>
                </div> --}}

                {{-- Body --}}
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Full Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input id="password" type="password" name="password" required
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="form-control">
                            </div>

                            {{-- Role / Type --}}
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-bold">Select Your Profile</label>
                                <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="" selected disabled>Choose your profile</option>
                                    <option value="User">Student</option>
                                    <option value="Author">Research Author</option>
                                    <option value="Admin">Adminstrator</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Button --}}
                         <div class="d-flex justify-content-center mt-6">
    <button type="submit" class="btn btn-primary fw-bold px-4 py-2" style="background-color:#066187; border-color:#066187;">
        Register
    </button>
</div>

                    </form>
                </div>

                {{-- Footer --}}
                <div class="card-footer text-center text-muted">
                    Already have an account? <a href="{{ route('login') }}" style="color:#066187;">Login here</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
