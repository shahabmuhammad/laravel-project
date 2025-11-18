@extends('front.layouts.master')

@section('title', 'Home | Research Repository')

@section('content')

    <!-- HERO SECTION -->
    <section class="hero py-5">
        <div class="container">
            <div class="row align-items-center ">
                <div class="col-lg-6 order-2 order-lg-1">
                    <h2 class="fw-bold text-primary-custom mb-4">
                        Discover & Share<br>Research Papers Online
                    </h2>
                    <p class="text-muted">
                        An open repository for research to publish and access knowledge freely.
                    </p>
                    <div class="mt-4 d-flex flex-column flex-sm-row gap-3">
                        <a href="{{ route('front.browse') }}" class="btn btn-primary-custom px-4">
                            <i class="bi bi-search me-2"></i>Browse Publications
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-warning text-white px-4">
                            <i class="bi bi-upload me-2"></i>Upload Paper
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 order-1 order-lg-2">
                    <img src="{{ asset('build/front/assets/images/hero.jpg') }}" alt="Research Repository Hero"
                        class="img-fluid rounded shadow" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- SEARCH BAR -->
    <section class="search-bar text-center my-4">
        <div class="container">
            <form action="{{ route('search') }}" method="GET" class="mx-auto" style="max-width:600px;">
                <div class="input-group shadow-sm">
                    <input type="text" name="query" value="{{ request('query') }}" class="form-control"
                        placeholder="Search by title, author or keyword" aria-label="Search publications">
                    <button class="btn btn-primary-custom px-4" type="submit">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- STATS -->
    <section class="stats-section py-5 bg-light border-top border-bottom text-center">
        <div class="container">
            <div class="row justify-content-center align-items-center ">

                <div class="col-6 col-md-3 col-l mx-auto">
                    <div class="text-center">
                        <i class="bi bi-people-fill text-warning d-block mb-3"></i>
                        <h4 class="fw-bold">{{ number_format($totalUsers) }}</h4>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-l mx-auto">
                    <div class="text-center">
                        <i class="bi bi-journal-text text-primary d-block mb-3"></i>
                        <h4 class="fw-bold">{{ number_format($totalPublications) }}</h4>
                        <p class="text-muted mb-0">Total Publications</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-l mx-auto">
                    <div class="text-center">
                        <i class="bi bi-person-badge text-success d-block mb-3"></i>
                        <h4 class="fw-bold">{{ number_format($totalRegistered) }}</h4>
                        <p class="text-muted mb-0">Total Registered</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FEATURED PUBLICATIONS -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Featured Publications</h4>
                <a href="{{ route('front.publications') }}"
                    class="btn btn-link text-primary fw-semibold d-none d-md-inline-flex">
                    View All <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>

            <div class="row ">
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
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                $previewImage = $file->getUrl();
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

                    <div class="col-12 col-sm-6 col-l">
                        <article class="card h-100 shadow-sm border-0">
                            <img src="{{ $previewImage }}" class="card-img-top" alt="{{ $item->title }}" loading="lazy">

                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold">
                                    <a href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}"
                                        class="text-decoration-none text-dark">{{ Str::limit($item->title, 60) }}</a>
                                </h6>

                                <p class="small text-muted mb-2">
                                    {{ $item->created_at?->format('Y') }}
                                    @if ($item->author)
                                        | Author: {{ Str::limit($item->author->name, 20) }}
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
                                            class="btn btn-outline-primary btn-sm flex-fill flex-sm-grow-0">View</a>
                                        <a href="{{ URL::signedRoute('front.publication.download', ['research' => $item->slug ?? $item->id]) }}"
                                            class="btn btn-outline-success btn-sm flex-fill flex-sm-grow-0">Download</a>
                                    </div>
                                </div>

                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4 d-md-none">
                <a href="{{ route('front.publications') }}" class="btn btn-link text-primary fw-semibold">
                    Find out more <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- EXPLORE BY FIELD -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="mb-4">
                <h4 class="fw-bold mb-2">Explore by Field</h4>
                <p class="text-muted">Discover popular research areas.</p>
            </div>

            <div class="row ">
                @foreach ($categories as $key => $category)
                    @php
                        $ext = $key % 12 < 6 ? 'jpg' : 'png';
                        $imgNumber = ($key % 12) + 1;
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="field-card p-4 bg-white rounded shadow-sm text-center h-100">
                            <img src="{{ asset('build/front/assets/images/field' . $imgNumber . '.' . $ext) }}"
                                class="field-img mx-auto" alt="{{ $category->name }}" loading="lazy">

                            <h6 class="field-title">{{ $category->name }}</h6>
                            <p class="small text-muted mb-0">
                                {{ Str::limit($category->description ?? 'Explore this field.', 60) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('front.view-category') }}" class="btn btn-link text-primary fw-semibold">
                    View All Categories <i class="bi bi-arrow-right ms-1"></i>
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
                    Our Online Research Repository is a digital platform designed to make academic knowledge accessible to
                    everyone.
                </p>
            </div>

            <div class="col-lg-6 text-center">
                <img src="{{ asset('build/front/assets/images/about.jpg') }}" class="img-fluid rounded shadow"
                    alt="">
            </div>
        </div>
    </section>

    <!-- JOIN COMMUNITY -->
    <section class="join py-5">
        <div class="container d-flex flex-column flex-lg-row align-items-center">
            <div class="col-lg-6 text-center">
                <img src="{{ asset('build/front/assets/images/join.jpg') }}" class="img-fluid rounded shadow"
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
