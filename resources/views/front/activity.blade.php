@extends('front.layouts.master')
@section('title', 'My Activity')

@section('content')
    <div class="container py-5">
        <!-- Page Header -->
        <div class="mb-4">
            <h2 class="fw-bold mb-2">My Activity</h2>
            <p class="text-muted">Track your research paper views, downloads, and bookmarks</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-eye-fill fs-1 text-info mb-3"></i>
                        <h3 class="fw-bold mb-1">{{ $stats['total_views'] }}</h3>
                        <p class="text-muted small mb-0">Total Views</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-download fs-1 text-success mb-3"></i>
                        <h3 class="fw-bold mb-1">{{ $stats['total_downloads'] }}</h3>
                        <p class="text-muted small mb-0">Total Downloads</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-bookmark-fill fs-1 text-primary mb-3"></i>
                        <h3 class="fw-bold mb-1">{{ $stats['total_bookmarks'] }}</h3>
                        <p class="text-muted small mb-0">Bookmarks</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-text-fill fs-1 text-warning mb-3"></i>
                        <h3 class="fw-bold mb-1">{{ $stats['unique_papers_viewed'] }}</h3>
                        <p class="text-muted small mb-0">Unique Papers</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4" id="activityTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="views-tab" data-bs-toggle="tab" data-bs-target="#views" type="button"
                    role="tab">
                    <i class="bi bi-eye me-2"></i>Recent Views
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="downloads-tab" data-bs-toggle="tab" data-bs-target="#downloads" type="button"
                    role="tab">
                    <i class="bi bi-download me-2"></i>Recent Downloads
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="bookmarks-tab" data-bs-toggle="tab" data-bs-target="#bookmarks" type="button"
                    role="tab">
                    <i class="bi bi-bookmark-fill me-2"></i>My Bookmarks
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="activityTabContent">
            <!-- Recent Views Tab -->
            <div class="tab-pane fade show active" id="views" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4">Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Views</th>
                                        <th>Last Viewed</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentViews as $paper)
                                        <tr>
                                            <td class="px-4">
                                                <div class="fw-semibold">{{ Str::limit($paper->title ?? 'Untitled', 60) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $paper->user->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @if (isset($paper->categories) && $paper->categories->count() > 0)
                                                    <span class="badge bg-light text-dark border">
                                                        {{ $paper->categories->first()->name }}
                                                    </span>
                                                    @if ($paper->categories->count() > 1)
                                                        <span
                                                            class="badge bg-light text-dark border">+{{ $paper->categories->count() - 1 }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $paper->user_views ?? 1 }}</span>
                                            </td>
                                            <td class="text-muted small">
                                                {{ isset($paper->last_viewed_at) ? \Carbon\Carbon::parse($paper->last_viewed_at)->format('M d, Y H:i') : 'N/A' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('front.publication.show', ['research' => $paper->slug ?? $paper->id]) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                                No viewed papers yet. Start exploring!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Downloads Tab -->
            <div class="tab-pane fade" id="downloads" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4">Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Downloads</th>
                                        <th>Last Downloaded</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentDownloads as $paper)
                                        <tr>
                                            <td class="px-4">
                                                <div class="fw-semibold">{{ Str::limit($paper->title ?? 'Untitled', 60) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $paper->user->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @if (isset($paper->categories) && $paper->categories->count() > 0)
                                                    <span class="badge bg-light text-dark border">
                                                        {{ $paper->categories->first()->name }}
                                                    </span>
                                                    @if ($paper->categories->count() > 1)
                                                        <span
                                                            class="badge bg-light text-dark border">+{{ $paper->categories->count() - 1 }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $paper->download_count ?? 1 }}</span>
                                            </td>
                                            <td class="text-muted small">
                                                {{ isset($paper->last_downloaded_at) ? \Carbon\Carbon::parse($paper->last_downloaded_at)->format('M d, Y H:i') : 'N/A' }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('front.publication.show', ['research' => $paper->slug ?? $paper->id]) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye me-1"></i>View
                                                    </a>
                                                    <a href="{{ route('front.publication.download', ['research' => $paper->slug ?? $paper->id]) }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-download me-1"></i>Download
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                                No downloads yet. Download papers to see them here!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookmarks Tab -->
            <div class="tab-pane fade" id="bookmarks" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4">Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Bookmarked On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookmarks as $paper)
                                        <tr>
                                            <td class="px-4">
                                                <div class="fw-semibold">{{ Str::limit($paper->title ?? 'Untitled', 60) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $paper->user->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @if (isset($paper->categories) && $paper->categories->count() > 0)
                                                    <span class="badge bg-light text-dark border">
                                                        {{ $paper->categories->first()->name }}
                                                    </span>
                                                    @if ($paper->categories->count() > 1)
                                                        <span
                                                            class="badge bg-light text-dark border">+{{ $paper->categories->count() - 1 }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="text-muted small">
                                                {{ $paper->pivot->created_at ? $paper->pivot->created_at->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('front.publication.show', ['research' => $paper->slug ?? $paper->id]) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye me-1"></i>View
                                                    </a>
                                                    <form
                                                        action="{{ route('front.bookmark.remove', ['research' => $paper->id]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Remove this bookmark?')">
                                                            <i class="bi bi-trash me-1"></i>Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                                No bookmarks yet. Start bookmarking papers!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
