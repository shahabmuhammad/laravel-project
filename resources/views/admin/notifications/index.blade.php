@extends('admin.layouts.master')
@section('title', 'Notifications')

@section('content')
    <div class="container-fluid p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold">Notifications</h3>
            @if ($user->hasRole('Admin'))
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">Send New</a>
            @endif
        </div>

        @foreach ($notifications as $notify)
            <div class="alert {{ $notify->is_read ? 'alert-secondary' : 'alert-info' }} shadow-sm">
                <strong>{{ $notify->title }}</strong><br>
                {{ $notify->message }}
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-muted">{{ $notify->created_at->diffForHumans() }}</small>
                    @if (!$notify->is_read)
                        <form action="{{ route('admin.notifications.read', $notify->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-dark">Mark as Read</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach

        @if ($notifications->isEmpty())
            <p>No notifications yet.</p>
        @endif

    </div>
@endsection
