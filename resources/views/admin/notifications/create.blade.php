@extends('admin.layouts.master')
@section('title', 'Send Notification')

@section('content')
    <div class="container-fluid p-4">

        <h3 class="fw-bold mb-3">Send Notification</h3>

        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">Select User</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Choose User --</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->getRoleNames()->first() }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" rows="4" class="form-control" required></textarea>
            </div>

            <button class="btn btn-success">Send Notification</button>
        </form>

    </div>
@endsection
