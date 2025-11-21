@extends('front.layouts.master')
@section('content')
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4 text-start">All Categories</h2>

        <div class="row g-4">
            @foreach ($categories as $key => $category)
                <div class="col-md-4 col-sm-6 d-flex justify-content-start">
                    <div class="field-card bg-white text-center rounded shadow-sm p-3"
                         style="width: 331px; height: 206px; border-radius: 10px; box-shadow: 0px 0px 3px rgba(0,0,0,0.25); transition: transform 0.3s, box-shadow 0.3s;">
                        
                        <img src="{{ asset('build/front/assets/images/field' . (($key % 12) + 1) . '.' . ($key % 12 < 6 ? 'jpg' : 'png')) }}"
                             alt="{{ $category->name }}"
                             class="field-icon mb-2"
                             style="max-width: 80px;">
                        
                        <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                        <p class="small text-muted mb-0">{{ $category->description ?? 'Explore this field.' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.field-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.field-icon {
    display: inline-block;
}
</style>
@endsection
