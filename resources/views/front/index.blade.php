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
                          <img src="{{asset('build/front/assets/images/icon1.png')}}" alt="Users" style="width:40px; height:40px;">
                   {{-- <i class="bi bi-people-fill fs-1 text-danger"></i> --}}
                        <h4 class="fw-bold">{{ number_format($totalUsers) }}</h4>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-l mx-auto">
                    <div class="text-center">
                     {{-- <i class="bi bi-journal-text fs-1 text-warning"></i> --}}
                      <img src="{{asset('build/front/assets/images/icon2.png')}}" alt="Publications" style="width:40px; height:40px;">
                        <h4 class="fw-bold">{{ number_format($totalPublications) }}</h4>
                        <p class="text-muted mb-0">Total Publications</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-l mx-auto">
                    <div class="text-center">
                        {{-- <i class="bi bi-person-badge-fill fs-1 text-success"></i> --}}
                         <img src="{{asset('build/front/assets/images/icon3.png')}}" alt="Registered"style="width:40px; height:40px;">
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
  <!-- ===== KEY FEATURES ===== -->
  <section class="features py-5 bg-light">
  <div class="container text-center">
    <h4 class="fw-bold mb-4 text-start">Key Features</h4>

    <div class="row g-4">

      <!-- Feature 1 -->
      <div class="col-md-3">
        <div class="p-4 bg-white rounded shadow-sm h-100">
          <i class="bi bi-search fs-1 text-warning mb-3"></i>

          <h6 class="fw-bold mt-3">Easy Search & Filter</h6>
          <p class="small text-muted">Find relevant research papers smartly.</p>
        </div>
      </div>

      <!-- Feature 2 -->
      <div class="col-md-3">
        <div class="p-4 bg-white rounded shadow-sm h-100">
          <i class="bi bi-people fs-1 text-success mb-3"></i>

          <h6 class="fw-bold mt-3">Academic Network</h6>
          <p class="small text-muted">Connect with global researchers.</p>
        </div>
      </div>

      <!-- Feature 3 -->
      <div class="col-md-3">
        <div class="p-4 bg-white rounded shadow-sm h-100">
       <i class="bi bi-file-earmark-arrow-down fs-1 mb-3" 
   style="color:#FFC107; text-shadow: 1px 1px 2px #ffffff;"></i>


          <h6 class="fw-bold mt-3">Downloads & Citations</h6>
          <p class="small text-muted">Get insights at a glance.</p>
        </div>
      </div>

      <!-- Feature 4 -->
      <div class="col-md-3">
        <div class="p-4 bg-white rounded shadow-sm h-100">
          <i class="bi bi-globe fs-1 mb-3" style="color:#0D3B66;"></i>

          <h6 class="fw-bold mt-3">Open Access</h6>
          <p class="small text-muted">Access research across all disciplines.</p>
        </div>
      </div>

    </div>

    <a href="{{ route('front.key-features') }}" class="btn btn-link text-primary fw-semibold mt-4">
      Find out more →
    </a>
  </div>
</section>
<!-- ===== EXPLORE BY FIELD ===== -->
<section class="explore-section py-5">
    <div class="container">
        <h3 class="fw-bold mb-2 text-start">Explore by Field</h3>
        <p class="section-desc mb-5 text-start">
            Discover popular research areas and dive into topics that interest you most.
        </p>

        <div class="row g-4">
            @foreach($categories as $key => $category)
                @php
                    $ext = ($key % 12) < 6 ? 'jpg' : 'png';
                    $imgNumber = ($key % 12) + 1;
                @endphp

                <div class="col-md-4 col-sm-6 d-flex justify-content-start">
                    <div class="explore-box bg-white text-center rounded shadow-sm p-3"
                         style="width: 331px; height: 206px; border-radius: 10px; box-shadow: 0px 0px 3px rgba(0,0,0,0.25); transition: transform 0.3s, box-shadow 0.3s;">
                        
                        <img src="{{ asset('build/front/assets/images/field' . $imgNumber . '.' . $ext) }}"
                             class="img-fluid mb-2"
                             style="max-width: 80px;"
                             alt="{{ $category->name }}">

                        <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                        <p class="small text-muted mb-0">{{ $category->description ?? 'Explore this field.' }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('front.view-category') }}" class="btn btn-link text-primary fw-semibold">
                View All Categories →
            </a>
        </div>
    </div>
</section>

<style>
.explore-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
</style>





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
                 Be part of a growing network of authors, reviewers, and readers who make research accessible to everyone.
                </p>
            </div>
        </div>
    </section>

@endsection
