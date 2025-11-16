@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Add Research Type</h2>

    <form action="{{ route('admin.types.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="type">Type Name</label>
            <input type="text" name="type" class="form-control" required placeholder="e.g. Proposal, Thesis, Idea">
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
