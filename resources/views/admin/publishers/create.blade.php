@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Add Publisher</h2>

    <form action="{{ route('admin.publishers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name">Publisher Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="website">Website</label>
            <input type="url" name="website" class="form-control" placeholder="https://example.com">
        </div>

        <div class="mb-3">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.publishers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
