@extends('front.layouts.master')
@section('title', 'My Bookmarks')

@section('content')
    <div class="container py-5">
        <!-- Page Header -->
        <div class="mb-4">
            <h2 class="fw-bold mb-2">My Bookmarks</h2>
            <p class="text-muted">Your saved research papers for quick access</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($bookmarks->count() > 0)
            <div class="row g-4">
                @foreach ($bookmarks as $paper)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <article class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex flex-column">
                                <!-- Title -->
                                <h5 class="card-title fw-bold mb-2">
                                    {{ Str::limit($paper->title, 80) }}
                                </h5>

                                <!-- Author -->
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-person me-1"></i>{{ $paper->user->name ?? 'Unknown' }}
                                </p>

                                <!-- Publisher/University -->
                                @if ($paper->publisher)
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-building me-1"></i>{{ $paper->publisher->name }}
                                    </p>
                                @endif

                                <!-- Categories -->
                                <div class="mb-3">
                                    @php
                                        $categories = $paper->categories();
                                    @endphp
                                    @if ($categories->count() > 0)
                                        @foreach ($categories->take(2) as $cat)
                                            <span class="badge bg-light text-dark border me-1">{{ $cat->name }}</span>
                                        @endforeach
                                        @if ($categories->count() > 2)
                                            <span
                                                class="badge bg-light text-dark border">+{{ $categories->count() - 2 }}</span>
                                        @endif
                                    @endif
                                </div>

                                <!-- Description -->
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($paper->description, 100) }}
                                </p>

                                <!-- Bookmarked Date -->
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-bookmark-fill text-primary me-1"></i>
                                    Saved on {{ $paper->pivot->created_at->format('M d, Y') }}
                                </p>

                                <!-- Stats & Actions -->
                                <div
                                    class="d-flex flex-column flex-sm-row justify-content-between align-items-start mt-auto gap-2">
                                    <small class="text-muted">
                                        <i class="bi bi-download me-1"></i>{{ number_format($paper->downloads ?? 0) }}
                                        <span class="mx-1">•</span>
                                        <i class="bi bi-eye me-1"></i>{{ number_format($paper->views ?? 0) }}
                                    </small>

                                    <div class="d-flex gap-2 w-100 w-sm-auto">
                                        <a href="{{ route('front.publication.show', ['research' => $paper->slug ?? $paper->id]) }}"
                                            class="btn btn-outline-primary btn-sm flex-fill flex-sm-grow-0">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                        <form action="{{ route('front.bookmark.remove', ['research' => $paper->id]) }}"
                                            method="POST" class="d-inline flex-fill flex-sm-grow-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                                onclick="return confirm('Remove this bookmark?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $bookmarks->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="bi bi-bookmark display-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Bookmarks Yet</h4>
                <p class="text-muted mb-4">Start exploring and bookmark papers you want to save for later!</p>
                <a href="{{ route('front.browse') }}" class="btn btn-primary">
                    <i class="bi bi-search me-2"></i>Browse Research Papers
                </a>
            </div>
        @endif
    </div>
@endsection
