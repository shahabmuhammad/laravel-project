@extends('front.layouts.master')
@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">All Categories</h2>

            <div class="row ">
                @foreach ($categories as $key => $category)
                    <div class="col-md-4 col-l">
                        <div class="p-4 bg-light rounded shadow-sm text-center h-100 field-card">
                            <img src="{{ asset('build/front/assets/images/field' . (($key % 12) + 1) . '.' . ($key % 12 < 6 ? 'jpg' : 'png')) }}"
                                alt="{{ $category->name }}" class="field-icon mb-3">
                            <h6 class="fw-bold">{{ $category->name }}</h6>
                            <p>{{ $category->description ?? 'Explore this field.' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
        </div>
    </section>
@endsection
