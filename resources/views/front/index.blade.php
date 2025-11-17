@extends('front.layouts.master')

@section('title', 'Home | Research Repository')

@section('content')

<!-- HERO SECTION -->
<section class="hero py-5">
    <div class="container d-flex flex-column flex-lg-row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h2 class="fw-bold text-primary-custom mb-4">
                Discover & Share<br>Research Papers Online
            </h2>
            <p class="text-muted mt-2">
                An open repository for research to publish and access knowledge freely.
            </p>
            <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="#" class="btn btn-primary-custom px-4">Browse Publications</a>
                <a href="#" class="btn btn-warning text-white px-4">Upload Paper</a>
            </div>
        </div>

        <div class="col-lg-6 text-center">
            <img src="{{ asset('build/front/assets/images/hero.jpg') }}"
                 alt="Hero Image"
                 class="img-fluid rounded shadow">
        </div>
    </div>
</section>

<!-- SEARCH BAR -->
<section class="search-bar text-center my-4">
    <div class="container">
        <form action="{{ route('search') }}" method="GET">
            <div class="input-group shadow-sm mx-auto" style="max-width:600px;">
                <input type="text"
                       name="query"
                       value="{{ request('query') }}"
                       class="form-control"
                       placeholder="Search by title, author or keyword">
                <button class="btn btn-primary-custom px-4">Search</button>
            </div>
        </form>
    </div>
</section>

<!-- STATS -->
<section class="stats-section py-5 bg-light border-top border-bottom text-center">
    <div class="container">
        <div class="row gy-4 justify-content-center">

            <div class="col-6 col-md-4">
                <div>
                    <i class="bi bi-people-fill fs-1 text-warning"></i>
                    <h4 class="fw-bold mt-2">{{ number_format($totalUsers) }}</h4>
                    <p class="text-muted">Total Users</p>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div>
                    <i class="bi bi-journal-text fs-1 text-primary"></i>
                    <h4 class="fw-bold mt-2">{{ number_format($totalPublications) }}</h4>
                    <p class="text-muted">Total Publications</p>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div>
                    <i class="bi bi-person-badge fs-1 text-success"></i>
                    <h4 class="fw-bold mt-2">{{ number_format($totalRegistered) }}</h4>
                    <p class="text-muted">Total Registered</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FEATURED PUBLICATIONS -->
<section class="py-5">
    <div class="container">
        <h4 class="fw-bold mb-4">Featured Publications</h4>

        <div class="row g-4">
            @foreach ($featuredResearches as $item)
                @php
                    $file = $item->getFirstMedia('research_files');
                    $ext = $file ? strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)) : null;

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

                    if ($file) {
                        if (in_array($ext, ['jpg','jpeg','png','gif'])) {
                            $previewImage = $file->getUrl();
                        } elseif ($ext == 'pdf') {
                            $previewImage = $pdfImages[$file->id % count($pdfImages)];
                        } elseif (in_array($ext, ['doc','docx'])) {
                            $previewImage = $docImages[$file->id % count($docImages)];
                        } else {
                            $previewImage = $otherImages[$file->id % count($otherImages)];
                        }
                    } else {
                        $previewImage = asset('build/front/assets/images/no-file.png');
                    }
                @endphp

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ $previewImage }}"
                             class="card-img-top"
                             alt="{{ $item->title }}">

                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold">
                                <a href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}"
                                   class="text-decoration-none text-dark">{{ $item->title }}</a>
                            </h6>

                            <p class="small text-muted">
                                {{ $item->created_at?->format('Y') }}
                                @if ($item->author) | Author: {{ $item->author->name }} @endif
                            </p>

                            @if (!empty($item->category_names))
                                <p>
                                    @foreach ($item->category_names as $cat)
                                        <a href="{{ route('front.view-category') }}"
                                           class="badge me-1"
                                           style="background-color:#066187;">{{ $cat }}</a>
                                    @endforeach
                                </p>
                            @endif

                            <div class="d-flex justify-content-between mt-auto">
                                <small class="text-muted">
                                    {{ number_format($item->downloads ?? 0) }} downloads •
                                    {{ number_format($item->views ?? 0) }} views
                                </small>

                                <div>
                                    <a href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}"
                                       class="btn btn-outline-primary btn-sm">View</a>
                                    <a href="{{ URL::signedRoute('front.publication.download', ['research' => $item->slug ?? $item->id]) }}"
                                       class="btn btn-outline-success btn-sm">Download</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('front.publications') }}" class="btn btn-link text-primary fw-semibold">Find out more →</a>
        </div>

    </div>
</section>

<!-- EXPLORE BY FIELD -->
<section class="py-5">
    <div class="container">
        <h4 class="fw-bold mb-3">Explore by Field</h4>
        <p class="text-muted">Discover popular research areas.</p>

        <div class="row g-4 mt-3">
            @foreach($categories as $key => $category)
                @php
                    $ext = ($key % 12) < 6 ? 'jpg' : 'png';
                    $imgNumber = ($key % 12) + 1;
                @endphp

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-4 bg-light rounded shadow-sm text-center h-100">
                        <img src="{{ asset('build/front/assets/images/field' . $imgNumber . '.' . $ext) }}"
                             class="img-fluid mb-3"
                             style="max-width: 80px;"
                             alt="{{ $category->name }}">

                        <h6 class="fw-bold">{{ $category->name }}</h6>
                        <p class="small">{{ $category->description ?? 'Explore this field.' }}</p>
                    </div>
                </div>

            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('front.view-category') }}" class="btn btn-link text-primary fw-semibold">
                View All Categories →
            </a>
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section class="about py-5 bg-light">
    <div class="container d-flex flex-column flex-lg-row align-items-center">
        <div class="col-lg-6 pe-lg-5 mb-4 mb-lg-0">
            <h5 class="fw-bold mb-3">About</h5>
            <p class="text-muted">
                Our Online Research Repository is a digital platform designed to make academic knowledge accessible to everyone.
            </p>
        </div>

        <div class="col-lg-6 text-center">
            <img src="{{ asset('build/front/assets/images/about.jpg') }}"
                 class="img-fluid rounded shadow"
                 alt="">
        </div>
    </div>
</section>

<!-- JOIN COMMUNITY -->
<section class="join py-5">
    <div class="container d-flex flex-column flex-lg-row align-items-center">
        <div class="col-lg-6 text-center">
            <img src="{{ asset('build/front/assets/images/join.jpg') }}"
                 class="img-fluid rounded shadow"
                 alt="">
        </div>

        <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0">
            <h5 class="fw-bold">Join Our Research Community</h5>
            <p class="text-muted">
                Be part of a growing network of authors, reviewers, and readers.
            </p>
        </div>
    </div>
</section>

@endsection
