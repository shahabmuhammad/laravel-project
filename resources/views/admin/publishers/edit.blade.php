@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Edit Publisher</h2>

    <form action="{{ route('admin.publishers.update',  Crypt::encrypt($publisher->id)) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">Publisher Name</label>
            <input type="text" name="name" class="form-control" value="{{ $publisher->name }}" required>
        </div>

        <div class="mb-3">
            <label for="website">Website</label>
            <input type="url" name="website" class="form-control" value="{{ $publisher->website }}">
        </div>

        <div class="mb-3">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" rows="3">{{ $publisher->address }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.publishers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
