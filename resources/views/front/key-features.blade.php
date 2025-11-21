@extends('front.layouts.master')
@section('content')
<!-- ===== KEY FEATURES SECTION ===== -->
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="fw-bold mb-5 text-start">Key Features</h3>

        <div class="row g-4"> <!-- g-4 adds spacing between cards -->

            @php
                $features = [
                    ['icon' => 'bi-search', 'color' => 'text-warning', 'title' => 'Easy Search & Filter', 'desc' => 'Find relevant research papers with smart search and advanced options.'],
                    ['icon' => 'bi-upload', 'color' => 'text-success', 'title' => 'Easy Share & Filter', 'desc' => 'A simple and secure way to share your research with the academic community.'],
                    ['icon' => 'bi-graph-up-arrow', 'color' => 'text-warning', 'title' => 'Downloads & Citation Stats', 'desc' => 'Easily downloadable with citation insights at a glance.'],
                    ['icon' => 'bi-globe', 'color' => 'text-primary', 'title' => 'Open Access for Everyone', 'desc' => 'Access a wide range of research papers across multiple disciplines.'],
                    ['icon' => 'bi-file-earmark-arrow-down', 'color' => 'text-warning', 'title' => 'Downloads & Save PDFs', 'desc' => 'Instant access to downloadable, high-quality PDFs.'],
                    ['icon' => 'bi-book', 'color' => 'text-success', 'title' => 'Comprehensive Library', 'desc' => 'Access a vast database of publications from multiple disciplines.'],
                    ['icon' => 'bi-person-circle', 'color' => 'text-warning', 'title' => 'Author Profiles', 'desc' => 'View detailed author information and publication history.'],
                    ['icon' => 'bi-chat-square-text', 'color' => 'text-primary', 'title' => 'Feedback & Reviews', 'desc' => 'Share your thoughts and rate publications.'],
                    ['icon' => 'bi-lightbulb', 'color' => 'text-warning', 'title' => 'Trending Topics', 'desc' => 'Find relevant research papers with smart search and advanced options.'],
                    ['icon' => 'bi-bell', 'color' => 'text-success', 'title' => 'Notifications & Alerts', 'desc' => 'Stay updated on new publications or category updates.'],
                    ['icon' => 'bi-bar-chart', 'color' => 'text-warning', 'title' => 'Citation Insights', 'desc' => 'View and track citation metrics and impact scores.'],
                    ['icon' => 'bi-shield-lock', 'color' => 'text-primary', 'title' => 'Secure & Reliable Platform', 'desc' => 'Access a wide range of research papers across multiple disciplines.'],
                ];
            @endphp

            @foreach($features as $feature)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="p-4 bg-white rounded shadow-sm text-center h-100 d-flex flex-column justify-content-start">
                    <i class="bi {{ $feature['icon'] }} fs-1 {{ $feature['color'] }} mb-3"></i>
                    <h6 class="fw-bold">{{ $feature['title'] }}</h6>
                    <p class="small text-muted">{{ $feature['desc'] }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
@endsection
