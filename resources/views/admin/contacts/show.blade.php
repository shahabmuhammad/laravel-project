@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">View Message</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5><strong>Name:</strong> {{ $contact->name }}</h5>
            <p><strong>Email:</strong> {{ $contact->email }}</p>
            <p><strong>Subject:</strong> {{ $contact->subject ?? 'N/A' }}</p>
            <p><strong>Message:</strong></p>
            <p class="border p-3 bg-light">{{ $contact->message }}</p>

            <p><strong>Date:</strong> {{ $contact->created_at->format('d M Y, h:i A') }}</p>

            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary mt-3">
                Back
            </a>

        </div>
    </div>
</div>

@endsection
