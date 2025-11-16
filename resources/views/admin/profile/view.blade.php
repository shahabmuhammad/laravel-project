@extends('admin.layouts.master')
@section('title', 'View Profile')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">Profile Details</h3>
    <div class="card p-4">
        <p><strong>Name:</strong> {{ $profileUser->name }}</p>
        <p><strong>Email:</strong> {{ $profileUser->email }}</p>
        <p><strong>Role:</strong> {{ $profileUser->roles->pluck('name')->implode(', ') }}</p>

        @if($profileUser->getFirstMediaUrl('profile_image'))
            <img src="{{ $profileUser->getFirstMediaUrl('profile_image') }}" class="rounded-circle mt-2" width="100" height="100">
        @endif
    </div>

    <a href="{{ route('admin.profiles.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
