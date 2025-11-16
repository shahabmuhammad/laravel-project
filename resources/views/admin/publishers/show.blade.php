@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Publisher Details</h2>

    <p><strong>Name:</strong> {{ $publisher->name }}</p>
    <p><strong>Website:</strong> <a href="{{ $publisher->website }}" target="_blank">{{ $publisher->website }}</a></p>
    <p><strong>Address:</strong> {{ $publisher->address ?? 'N/A' }}</p>

    <a href="{{ route('admin.publishers.index', Crypt::encrypt($publisher->id)) }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
