@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Edit Research Type</h2>

    <form action="{{ route('admin.types.update', Crypt::encrypt($type->id)) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="type">Type Name</label>
            <input type="text" name="type" class="form-control" value="{{ $type->type }}" required>
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $type->description }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
