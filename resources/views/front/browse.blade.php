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

                    <input type="text" class="form-control" name="query"
                           value="{{ request('query') }}"
                           placeholder="Search by title, author or keyword">
                    <button type="submit" class="btn btn-primary-custom px-4">Search</button>
                </div>
            </form>
        </section>

        <!-- Filters -->
      <div class="row g-3 mb-5 mt-3">

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
        <div class="row g-4">

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
                        if (in_array($ext, ['jpg','jpeg','png','gif'])) {
                            $previewImage = $file->getUrl(); // actual image
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

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <img src="{{ $previewImage }}" class="card-img-top" alt="{{ $item->title }}">

                        <div class="card-body">
                            <h6 class="fw-bold">
                                <a href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}"
                                   class="text-decoration-none text-dark">
                                   {{ $item->title }}
                                </a>
                            </h6>

                            <p class="small text-muted mb-2">
                                {{ $item->created_at?->format('Y') }}
   @if(isset($item->author_name))
    | Author: {{ $item->author_name }}
@endif


                            </p>

                            @if (!empty($item->category_names))
                                <p class="mb-2">
                                    @foreach ($item->category_names as $cat)
                                        <span class="badge text-light"
                                              style="background-color: #066187">
                                              {{ $cat }}
                                        </span>
                                    @endforeach
                                </p>
                            @endif

                            <!-- Single Button (View Details Only) -->
                            <div class="text-end">
                                <a href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}"
                                   class="btn btn-primary btn-sm">
                                   View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

        </div> <!-- row end -->
    </div>
</section>

@endsection
