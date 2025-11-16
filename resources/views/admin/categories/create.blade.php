@extends('admin.layouts.master')


@section('title', 'Add Category')

@section('content')
<div class="container mt-4">
    <h3>Add New Category</h3>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
