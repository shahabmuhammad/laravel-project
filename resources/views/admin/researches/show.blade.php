@extends('admin.layouts.master')

@section('title', 'View Research')

@section('content')
<div class="container mt-4">

    <h3>{{ $research->title }}</h3>

    <p><strong>Description:</strong></p>
    <p>{{ $research->description }}</p>

    <ul class="list-group mb-3">
        <li class="list-group-item">
            <strong>Category:</strong> {{ $categories ? implode(', ', $categories) : '-' }}
        </li>
        <li class="list-group-item">
            <strong>Uploader:</strong> {{ $research->user->name ?? 'Unknown' }}
        </li>
        @if($research->author)
        <li class="list-group-item">
            <strong>Co-Author:</strong> {{ $research->author->name ?? '-' }}
        </li>
        @endif
        <li class="list-group-item"><strong>Publisher:</strong> {{ $research->publisher->name ?? '-' }}</li>
        <li class="list-group-item"><strong>Type:</strong> {{ $research->type->type ?? '-' }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($research->status) }}</li>
    </ul>

    @if($research->hasMedia('research_files'))
        @php
            $file = $research->getFirstMedia('research_files');
        @endphp
        <p><strong>File:</strong>
            <a href="{{ asset('media/' . $file->id . '/' . $file->file_name) }}" target="_blank" >
                View / Download
            </a>
        </p>
    @endif

    <a href="{{ route('admin.researches.index') }}" class="btn btn-secondary">Back</a>


</div>
@endsection
