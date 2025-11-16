@extends('admin.layouts.master')

@section('title', 'Edit Category')

@section('content')
<div class="container mt-4">
    <h3>Edit Category</h3>

    <form action="{{ route('admin.categories.update',  Crypt::encrypt($category->id)) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
