@extends('admin.layouts.master')

@section('title', 'User Profile')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">User Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-2">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ explode(' ', $user->name)[0] ?? '' }}">
            </div>
            <div class="col-md-6 mb-2">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ explode(' ', $user->name)[1] ?? '' }}">
            </div>

            <div class="col-md-6 mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
            </div>

            <div class="col-md-6 mb-2">
                <label>Contact</label>
                <input type="text" name="contact" class="form-control">
            </div>

            <div class="col-md-6 mb-2">
                <label>Country</label>
                <input type="text" name="country" class="form-control">
            </div>

            <div class="col-md-6 mb-2">
                <label>City</label>
                <input type="text" name="city" class="form-control">
            </div>

            <div class="col-md-6 mb-2">
                <label>Institute</label>
                <input type="text" name="institute" class="form-control">
            </div>

            <div class="col-md-12 mb-2">
                <label>About Me</label>
                <textarea name="about" rows="4" class="form-control"></textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label>Profile Image</label>
                <input type="file" name="profile_image" class="form-control">
                @if($user->getFirstMediaUrl('profile_image'))
                    <img src="{{ $user->getFirstMediaUrl('profile_image') }}" class="mt-2 rounded-circle" width="100" height="100">
                @endif
            </div>

            <div class="col-md-6 mb-2">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control">
            </div>

            <div class="col-md-6 mb-2">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control">
            </div>

            <div class="col-md-6 mb-2">
                <label>Confirm New Password</label>
                <input type="password" name="new_password_confirmation" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
    </form>
</div>
@endsection
