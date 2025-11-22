@extends('front.layouts.master')

@section('content')
    <!-- Browse Section -->
    <section class="py-5">
        <div class="container">

            <h3 class="fw-bold mb-4">Browse Publications</h3>

            <!-- SEARCH BAR -->
            <section class="search-bar my-4 w-100">

                <form action="{{ route('search') }}" method="GET">
                    <div class="input-group mb-4 shadow-sm w-100" style="max-width:600px;">

                        <input type="text" class="form-control" name="query" value="{{ request('query') }}"
                            placeholder="Search by title, author or keyword">
                        <button type="submit" class="btn btn-primary-custom px-4">Search</button>
                    </div>
                </form>
            </section>

            <!-- Filters -->
            <div class="row mb-5 mt-3">

                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Category</label>
                    <input type="text" class="form-control" placeholder="Computer Science">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Publication Year</label>
                    <select class="form-select">
                        <option selected>2023</option>
                        <option>2024</option>
                        <option>2025</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Author</label>
                    <input type="text" class="form-control" placeholder="Author">
                </div>
            </div>

            <!-- PUBLICATION CARDS -->
            <div class="row ">

                @foreach ($publications as $item)
                    @php
                        $file = $item->getFirstMedia('research_files');
                        $ext = $file ? strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)) : null;

                        // Predefined images
                        $pdfImages = [
                            asset('build/front/assets/images/pub1.jpg'),
                            asset('build/front/assets/images/pub2.jpg'),
                            asset('build/front/assets/images/pub3.jpg'),
                            asset('build/front/assets/images/pub4.jpg'),
                        ];
                        $docImages = [
                            asset('build/front/assets/images/pub5.jpg'),
                            asset('build/front/assets/images/pub6.jpg'),
                            asset('build/front/assets/images/pub7.jpg'),
                        ];
                        $otherImages = [
                            asset('build/front/assets/images/pub8.jpg'),
                            asset('build/front/assets/images/pub9.jpg'),
                            asset('build/front/assets/images/pub10.jpg'),
                            asset('build/front/assets/images/pub11.jpg'),
                        ];

                        // Stable Image Selection
                        if ($file) {
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                $previewImage = $file->getUrl(); // actual image
                            } elseif ($ext == 'pdf') {
                                $previewImage = $pdfImages[$file->id % count($pdfImages)];
                            } elseif (in_array($ext, ['doc', 'docx'])) {
                                $previewImage = $docImages[$file->id % count($docImages)];
                            } else {
                                $previewImage = $otherImages[$file->id % count($otherImages)];
                            }
                        } else {
                            $previewImage = asset('build/front/assets/images/no-file.png');
                        }
                    @endphp

                    <div class="col-12 col-sm-6 col-l my-2">
                        <article class="card h-100 shadow-sm border-0 ">
                            <img src="{{ $previewImage }}" class="card-img-top" alt="{{ $item->title }}" loading="lazy">

                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold">
                                    <a href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}"
                                        class="text-decoration-none text-dark">{{ Str::limit($item->title, 60) }}</a>
                                </h6>

                                <p class="small text-muted mb-2">
                                    {{ $item->created_at?->format('Y') }}
                                    @if (isset($item->author_name))
                                        | Author: {{ Str::limit($item->author_name, 20) }}
                                    @endif
                                </p>

                                @if (!empty($item->category_names))
                                    <div class="mb-3">
                                        @foreach (array_slice($item->category_names, 0, 2) as $cat)
                                            <a href="{{ route('front.view-category') }}" class="badge me-1 mb-1"
                                                style="background-color:#066187;">{{ $cat }}</a>
                                        @endforeach
                                    </div>
                                @endif

                                <div
                                    class="d-flex flex-column flex-sm-row justify-content-between align-items-start mt-auto gap-2">
                                    <small class="text-muted">
                                        <i class="bi bi-download me-1"></i>{{ number_format($item->downloads ?? 0) }}
                                        <span class="mx-1">•</span>
                                        <i class="bi bi-eye me-1"></i>{{ number_format($item->views ?? 0) }}
                                    </small>

                                    <div class="d-flex gap-2 w-100 w-sm-auto">
                                        <a href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}"
                                            class="btn btn-outline-primary btn-sm flex-fill flex-sm-grow-0">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                        @auth
                                            <button type="button" class="btn btn-outline-secondary btn-sm bookmark-btn"
                                                data-id="{{ $item->id }}" title="Bookmark">
                                                @if (auth()->user()->bookmarks()->where('research_id', $item->id)->exists())
                                                    <i class="bi bi-bookmark-fill"></i>
                                                @else
                                                    <i class="bi bi-bookmark"></i>
                                                @endif
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm"
                                                title="Login to bookmark">
                                                <i class="bi bi-bookmark"></i>
                                            </a>
                                        @endauth
                                        <a href="{{ route('front.publication.download', ['research' => $item->slug ?? $item->id]) }}"
                                            class="btn btn-outline-success btn-sm flex-fill flex-sm-grow-0">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </article>
                    </div>
                @endforeach

            </div> <!-- row end -->
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');

            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }

            document.querySelectorAll('.bookmark-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const icon = this.querySelector('i');

                    fetch(`{{ url('/bookmark/toggle') }}/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken.content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => {
                            if (!res.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return res.json();
                        })
                        .then(data => {
                            if (data.bookmarked) {
                                icon.className = 'bi bi-bookmark-fill';
                            } else {
                                icon.className = 'bi bi-bookmark';
                            }
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            alert('Failed to update bookmark. Please try again.');
                        });
                });
            });
        });
    </script>
@endpush
