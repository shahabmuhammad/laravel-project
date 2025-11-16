@extends('admin.layouts.master')
@section('title', 'Notification Details')

@section('content')
    <div class="container-fluid p-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="fw-bold">{{ $notification->title }}</h4>
                <p>{{ $notification->message }}</p>
                <p class="text-muted small mb-0">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary mt-3">← Back to Notifications</a>
    </div>
@endsection
