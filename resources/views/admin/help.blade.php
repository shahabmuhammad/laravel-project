@extends('admin.layouts.master')

@section('title', 'Help & Support')

@section('content')
<div class="container-fluid  pt-3 px-3 pb-3">
    <h4 class="mb-2" style="font-size:1.25rem;">Help & Support</h4>
    <p class="text-muted mb-3" style="font-size:0.875rem;">Need assistance? Find guides, FAQs, and contact support here.</p>

    {{-- 📘 Guides Section --}}
    <div class="card shadow-sm mb-3" style="border-left: 4px solid #066187;">
        <div class="card-header" style="background-color:#066187; color:white; font-size:0.95rem;">
            <h6 class="mb-0"><i class="fas fa-book me-2"></i>Guides</h6>
        </div>
        <div class="card-body" style="font-size:0.85rem;">
            <ul class="ps-3 mb-0">
                <li><strong>Student Guide:</strong> Step-by-step instructions for browsing and accessing research papers.</li>
                <li><strong>Author / Faculty Guide:</strong> How to submit, manage, and track your publications.</li>
                <li><strong>Administrator Guide:</strong> Managing users, roles, categories, and analytics dashboard.</li>
            </ul>
        </div>
    </div>

    {{-- ❓ FAQs Section --}}
    <div class="card shadow-sm mb-3" style="border-left: 4px solid #066187;">
        <div class="card-header" style="background-color:#066187; color:white; font-size:0.95rem;">
            <h6 class="mb-0"><i class="fas fa-question-circle me-2"></i>Frequently Asked Questions</h6>
        </div>
        <div class="card-body" style="font-size:0.85rem;">
            <ul class="ps-3 mb-0">
                <li>How do I approve a publication?</li>
                <li>How can I add a new category?</li>
                <li>Where can I manage user roles?</li>
                <li>How do I track paper views and downloads?</li>
            </ul>
        </div>
    </div>

    {{-- 📧 Contact Support --}}
    <div class="card shadow-sm mb-3" style="border-left: 4px solid #066187;">
        <div class="card-header" style="background-color:#066187; color:white; font-size:0.95rem;">
            <h6 class="mb-0"><i class="fas fa-envelope me-2"></i>Contact Admin Support</h6>
        </div>
        <div class="card-body" style="font-size:0.85rem;">
            <p>If you need further assistance, reach out to our support team:</p>
            <ul class="ps-3 mb-0">
                <li>Email: <a href="mailto:support@repository.com">support@repository.com</a></li>
                <li>Phone: +1 (123) 456-7890</li>
            </ul>
        </div>
    </div>

    {{-- 🔗 Useful Links --}}
    <div class="card shadow-sm p-3 mt-3" style="border-left: 4px solid #066187;">
        <h6 class="mb-2" style="font-size:0.95rem;"><i class="fas fa-link me-2"></i>Useful Links</h6>
        <ul class="ps-3 mb-0" style="font-size:0.85rem;">
            <li><a href="{{ route('admin.researches.index') }}">Browse All Publications</a></li>
            <li><a href="{{ route('admin.categories.index') }}">Manage / Browse Categories</a></li>
            <li><a href="{{ route('admin.analytics') }}">View Analytics Dashboard</a></li>
            <li><a href="{{ route('admin.bookmark.index') }}">My Bookmarked Papers</a></li>
        </ul>
    </div>
</div>
@endsection
