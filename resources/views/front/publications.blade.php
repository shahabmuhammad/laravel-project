@extends('front.layouts.master')


@section('content')
    <section class="container my-5">
        <h4 class="fw-bold mb-4">{{ isset($category) ? 'Publications in: ' . $category->name : 'Publications' }}</h4>

        <div class="row ">
            @if (isset($researches) && $researches->count())
                @foreach ($researches as $item)
                    <div class="col-md-4">
                        <div class="card publication-card shadow-sm border-0">
                            <img src="{{ asset('build/front/assets/images/images/pub1.jpg') }}" class="card-img-top"
                                alt="{{ $item->title }}">
                            <div class="card-body">
                                <h6 class="fw-semibold"><a
                                        href="{{ route('front.publication.show', ['research' => $item->slug ?? $item->id]) }}">{{ $item->title }}</a>
                                </h6>
                                <p class="small text-muted mb-2">
                                    {{ $item->created_at?->format('Y') ?? '' }} | Author: {{ $item->author?->name ?? '—' }}
                                    <br>
                                    Categories: @foreach ($item->category_names ?? [] as $c)
                                        <span class="badge bg-light me-1">{{ $c }}</span>
                                    @endforeach
                                </p>
                                <a href="{{ URL::signedRoute('front.publication.download', ['research' => $item->slug ?? $item->id]) }}"
                                    class="btn btn-success btn-sm w-100">Download PDF</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12 mt-4">
                    {{ $researches->links() }}
                </div>
            @else
                <div class="col-12">
                    <p class="text-muted">No publications found.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
