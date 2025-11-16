@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Type Details</h2>

    <p><strong>Type:</strong> {{ $type->type }}</p>
    <p><strong>Description:</strong> {{ $type->description ?? 'N/A' }}</p>

    <a href="{{ route('admin.types.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
