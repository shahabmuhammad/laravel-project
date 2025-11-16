@extends('front.layouts.master')

@section('content')

<!-- CONTACT SECTION -->
<section class="contact-section py-5">
    <div class="container">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header & Map -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="fw-bold" style="font-size: 32px;">Get in Touch</h2>
                <p class="lead" style="font-size: 18px;">
                    We'd love to hear from you! Reach out with any questions, feedback, or collaboration ideas.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mb-4 mb-md-0">
                <img src="{{ asset('build/front/assets/images/map.jpg') }}" 
                     alt="Map" class="img-fluid rounded shadow-sm" style="max-height: 220px;">
            </div>
        </div>

        <!-- Contact Form & Info -->
        <div class="row gx-5">

            <!-- ===== FORM ===== -->
            <div class="col-lg-6 mb-4">
                <form class="contact-form" action="{{ route('front.contact.store') }}" method="POST">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <input type="text" 
                                   class="form-control" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Full Name" 
                                   required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" 
                                   class="form-control" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Email Address" 
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <input type="text" 
                               class="form-control" 
                               name="subject" 
                               value="{{ old('subject') }}" 
                               placeholder="Subject">
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control" 
                                  name="message" 
                                  rows="5" 
                                  placeholder="Message" 
                                  required>{{ old('message') }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary-custom px-5">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- ===== CONTACT INFO ===== -->
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="d-flex flex-column justify-content-start h-100">
                    <h5 class="fw-semibold mb-3">Contact Information</h5>
                    <p><i class="bi bi-envelope me-2 text-primary"></i> info@repository.org</p>
                    <p><i class="bi bi-telephone me-2 text-primary"></i> +123 456 789</p>

                    <h6 class="fw-semibold mt-4 mb-2">Follow Us</h6>
                    <div class="social-links mb-4">
                        <a href="#" class="me-2"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="me-2"><i class="bi bi-linkedin fs-5"></i></a>
                        <a href="#"><i class="bi bi-github fs-5"></i></a>
                    </div>

                    <h5 class="fw-semibold mb-3">Need help with something specific?</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="help-link d-block mb-2">FAQ Page</a></li>
                        <li><a href="#" class="help-link d-block mb-2">Upload Guidelines</a></li>
                        <li><a href="#" class="help-link d-block">Report an Issue</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
