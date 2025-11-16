@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Category Details</h2>
    <p><strong>Name:</strong> {{ $category->name }}</p>
    <p><strong>Description:</strong> {{ $category->description }}</p>

    <h4 class="mt-4">Related Researches</h4>
    <ul>
        @forelse($category->researches as $research)
            <li>{{ $research->title }}</li>
        @empty
            <li>No researches found for this category.</li>
        @endforelse
    </ul>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
