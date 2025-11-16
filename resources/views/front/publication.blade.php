@extends('front.layouts.master')

@section('title', $research->title ?? 'Publication')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="fw-bold">{{ $research->title }}</h2>

                <p class="text-muted small">
                    @if ($research->user)
                        Author: {{ $research->user->name }}
                    @endif
                    @if ($research->publisher)
                        | Publisher: {{ $research->publisher->name }}
                    @endif
                    @if ($research->type)
                        | Type: {{ $research->type->type }}
                    @endif
                    @if ($research->created_at)
                        | {{ $research->created_at->format('Y') }}
                    @endif
                </p>

                @if (!empty($research->category_names))
                    <p>
                        @foreach ($research->category_names as $cat)
                            <a href="{{ route('front.view-category') }}"
                               class="badge bg-light me-1">{{ $cat }}</a>
                        @endforeach
                    </p>
                @endif

                <div class="my-4">
                    {!! nl2br(e($research->description)) !!}
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        {{ number_format($research->downloads ?? 0) }} downloads •
                        {{ number_format($research->views ?? 0) }} views
                    </div>

                    <div>
                        <a href="{{ URL::signedRoute('front.publication.download', ['research' => $research->slug ?? $research->id]) }}"
                           class="btn btn-success">
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-3">
                    <h6 class="fw-bold">Details</h6>
                    <ul class="list-unstyled small">
                        <li><strong>Author:</strong> {{ $research->user?->name ?? '—' }}</li>
                        <li><strong>Publisher:</strong> {{ $research->publisher?->name ?? '—' }}</li>
                        <li><strong>Type:</strong> {{ $research->type?->type ?? '—' }}</li>
                        <li><strong>Published:</strong> {{ $research->created_at?->format('Y-m-d') ?? '—' }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('front.home') }}" class="btn btn-link">← Back to Home</a>
        </div>
    </div>
</section>
@endsection
