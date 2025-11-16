@extends('front.layouts.master')
@section('content')
    
 <!-- ===== ABOUT SECTION ===== -->
  <section class="about-section py-5 bg-light text-dark">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h3 class="fw-bold mb-3">About</h3>
          <p>Our Online Research Repository is a digital platform designed to make academic knowledge accessible to everyone. It allows researchers, students, and professionals to publish, share, and discover research papers across multiple disciplines.</p>
        </div>
        <div class="col-md-6 text-center">
          <img src="{{asset('build/front/assets/images/about-banner.jpg')}}" alt="About us" class="img-fluid rounded">
        </div>
      </div>
    </div>
  </section>

  <!-- Mission -->
  <section class="mission py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <img src="{{asset('build/front/assets/images/mission.jpg')}}" alt="Mission" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6">
          <h5 class="fw-bold">Our Mission</h5>
          <p>To make academic research accessible to everyone. We aim to simplify how research is shared, discovered, and cited, helping authors gain visibility and readers find trusted knowledge efficiently.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Vision -->
  <section class="vision py-5 bg-light">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h5 class="fw-bold">Our Vision</h5>
          <p>We envision a world where research is open, connected, and impactful where every discovery reaches the people who can use it to make a difference.</p>
        </div>
        <div class="col-md-6 text-center">
          <img src="{{asset('build/front/assets/images/vision.jpg')}}" alt="Vision" class="img-fluid rounded shadow">
        </div>
      </div>
    </div>
  </section>

  <!-- Team -->
  <section class="team py-5 text-center">
    <div class="container">
      <h4 class="fw-bold mb-5">Meet Our Team</h4>
      <div class="row justify-content-center">
        <div class="col-md-3">
          <img src="{{asset('build/front/assets/images/team1.jpg')}}" alt="Ibrahim" class="rounded-circle mb-3" width="120" height="120">
          <h6>Ibrahim</h6>
          <p class="text-muted small">Founder & CEO</p>
        </div>
        <div class="col-md-3">
          <img src="{{asset('build/front/assets/images/team2.jpg')}}" alt="Sania" class="rounded-circle mb-3" width="120" height="120">
          <h6>Sania</h6>
          <p class="text-muted small">Community Manager</p>
        </div>
        <div class="col-md-3">
          <img src="{{asset('build/front/assets/images/team3.jpg')}}" alt="Habiba" class="rounded-circle mb-3" width="120" height="120">
          <h6>Habiba</h6>
          <p class="text-muted small">Technical Lead</p>
        </div>
      </div>
    </div>
  </section>


@endsection