@extends('front.layouts.master')

@section('title', 'Home | Research Repository')

@section('content')

    <!-- HERO SECTION -->
    <section class="hero py-5">
        <div class="container d-flex flex-column flex-lg-row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold text-primary-custom mb-4">
                    Discover & Share<br>Research Papers Online
                </h2>
                <p class="text-muted mt-2">
                    An open repository for research to publish and access knowledge freely.
                </p>
                <div class="mt-3">
                    <button class="btn btn-primary-custom me-2 px-4">Browse Publications</button>
                    <button class="btn btn-warning text-white">Upload Paper</button>
                </div>
            </div>
            <div class="col-lg-6 text-center mt-4 mt-lg-0">
                <img src="{{ asset('build/front/assets/images/hero.jpg') }}" alt="Hero Image"
                    class="img-fluid rounded shadow">
            </div>
        </div>
    </section>

    <!-- SEARCH BAR -->
       <section class="search-bar text-center my-4">
        <div class="container">
            <form action="{{ route('search') }}" method="GET">
            <div class="input-group shadow-sm mx-auto" style="max-width:600px;">
                <input type="text" class="form-control" name="query" value="{{ request('query') }}" placeholder="Search by title, author or keyword">
                <button type="submit" class="btn btn-primary-custom px-4">Search</button>
            </div>
            </form>
        </div>
    </section>
<!-- STATS -->
<section class="stats-section py-5 bg-light border-top border-bottom text-center">
    <div class="container">
        <div class="row justify-content-center gy-4">
            <div class="col-6 col-md-4">
                <div class="stat-item">
                    <i class="bi bi-people-fill fs-1 text-warning"></i>
                    <h4 class="fw-bold mt-2 mb-1">{{ number_format($totalUsers) }}</h4>
                    <p class="text-muted mb-0">Total Users</p>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="stat-item">
                    <i class="bi bi-journal-text fs-1 text-primary"></i>
                    <h4 class="fw-bold mt-2 mb-1">{{ number_format($totalPublications) }}</h4>
                    <p class="text-muted mb-0">Total Publications</p>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="stat-item">
                    <i class="bi bi-person-badge fs-1 text-success"></i>
                    <h4 class="fw-bold mt-2 mb-1">{{ number_format($totalRegistered) }}</h4>
                    <p class="text-muted mb-0">Total Registered</p>
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

                    // Stable image selection using file ID
                    if ($file) {
                        if (in_array($ext, ['jpg','jpeg','png','gif'])) {
                            $previewImage = $file->getUrl(); // actual image
                        } elseif ($ext == 'pdf') {
                            $index = $file->id % count($pdfImages);
                            $previewImage = $pdfImages[$index];
                        } elseif (in_array($ext, ['doc','docx'])) {
                            $index = $file->id % count($docImages);
                            $previewImage = $docImages[$index];
                        } else {
                            $index = $file->id % count($otherImages);
                            $previewImage = $otherImages[$index];
                        }
                    } else {
                        $previewImage = asset('build/front/assets/images/no-file.png');
                    }
                @endphp

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ $previewImage }}" class="card-img-top" alt="{{ $item->title }}">
                        <div class="card-body">
                            <h6 class="fw-bold">
                                <a href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}"
                                   class="text-decoration-none text-dark">{{ $item->title }}</a>
                            </h6>

                            <p class="small text-muted mb-2">
                                {{ $item->created_at?->format('Y') ?? '' }}
                                @if ($item->author)
                                    | Author: {{ $item->author->name }}
                                @endif
                            </p>

                            @if (!empty($item->category_names))
                                <p class="mb-2">
                                    @foreach ($item->category_names as $cat)
                                        <a href="{{ route('front.view-category') }}"
                                           class="badge text-decoration-none me-1"
                                           style="background-color: #066187">{{ $cat }}</a>
                                    @endforeach
                                </p>
                            @endif

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="small text-muted">
                                    {{ number_format($item->downloads ?? 0) }} downloads •
                                    {{ number_format($item->views ?? 0) }} views
                                </div>
                                <div>
                                    <a href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}"
                                       class="btn btn-outline-primary btn-sm me-2">View</a>
                                    <a href="{{ URL::signedRoute('front.publication.download', ['research' => $item->slug ?? $item->id]) }}"
                                       class="btn btn-outline-success btn-sm">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

        </div>

        <!-- Button -->
        <div class="text-center mt-4">
            <a href="{{ route('front.publications') }}" class="btn btn-link text-primary fw-semibold">Find out more →</a>
        </div>
    </div>
</section>


    <!-- KEY FEATURES -->
    <section class="features py-5 bg-light">
        <div class="container text-center">
            <h4 class="fw-bold mb-4 text-start">Key Features</h4>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded shadow-sm h-100">
                        <i class="bi bi-search fs-2 text-primary"></i>
                        <h6 class="fw-bold mt-3">Easy Search & Filter</h6>
                        <p class="small text-muted">Find relevant research papers smartly.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded shadow-sm h-100">
                        <i class="bi bi-people fs-2 text-warning"></i>
                        <h6 class="fw-bold mt-3">Academic Network</h6>
                        <p class="small text-muted">Connect with global researchers.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded shadow-sm h-100">
                        <i class="bi bi-download fs-2 text-success"></i>
                        <h6 class="fw-bold mt-3">Downloads & Citations</h6>
                        <p class="small text-muted">Get insights at a glance.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded shadow-sm h-100">
                        <i class="bi bi-globe fs-2 text-info"></i>
                        <h6 class="fw-bold mt-3">Open Access</h6>
                        <p class="small text-muted">Access research across all disciplines.</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('front.key-features') }}" class="btn btn-link text-primary fw-semibold mt-4">Find out more
                →</a>
        </div>
    </section>

    <!-- EXPLORE BY FIELD -->
 <section class="py-5">
    <div class="container">
        <h4 class="fw-bold mb-3">Explore by Field</h4>
        <p class="text-muted">
            Discover popular research areas and dive into topics that interest you most.
        </p>

       
          <div class="row g-4 mt-3">
    @foreach($categories as $key => $category)
        @php
            // Determine extension: first 6 are jpg, next 6 are png
            $ext = ($key % 12) < 6 ? 'jpg' : 'png';
            $imgNumber = ($key % 12) + 1;
        @endphp
        <div class="col-md-4 col-lg-4">
            <div class="p-4 bg-light rounded shadow-sm text-center h-100 field-card">
                <!-- Correct icon -->
                <img src="{{ asset('build/front/assets/images/field' . $imgNumber . '.' . $ext) }}" 
                     alt="{{ $category->name }}" class="field-icon mb-3">
                <h6 class="fw-bold">{{ $category->name }}</h6>
                <p>{{ $category->description ?? 'Explore this field.' }}</p>
            </div>
        </div>
    @endforeach
</div>


        <div class="text-center mt-4">
           <a href="{{ route('front.view-category') }}">View All Categories →</a>
        </div>
    </div>
</section>


    <!-- ABOUT SECTION -->
    <section class="about py-5 bg-light">
        <div class="container d-flex flex-column flex-lg-row align-items-center">
            <div class="col-lg-6 pe-lg-5">
                <h5 class="fw-bold mb-3">About</h5>
                <p class="text-muted">
                    Our Online Research Repository is a digital platform designed to make academic knowledge accessible to
                    everyone. It allows researchers, students, and professionals to publish, share, and discover research
                    papers across multiple disciplines.
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
            <div class="col-lg-6 text-center text-lg-start">
                <img src="{{ asset('build/front/assets/images/join.jpg') }}" class="img-fluid rounded shadow"
                    alt="">
            </div>
            <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0">
                <h5 class="fw-bold">Join Our Research Community</h5>
                <p class="text-muted">
                    Be part of a growing network of authors, reviewers, and readers who make research accessible to
                    everyone.
                </p>
            </div>
        </div>
    </section>

@endsection
