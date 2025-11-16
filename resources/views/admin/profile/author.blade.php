@extends('admin.layouts.master')

@section('title', 'Author Profile')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">Author Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-2">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="col-md-6 mb-2">
                <label>Paper Title</label>
                <input type="text" name="paper_title" class="form-control">
            </div>

            <div class="col-md-12 mb-2">
                <label>Abstract</label>
                <textarea name="abstract" rows="4" class="form-control"></textarea>
            </div>

            <div class="col-md-6 mb-2">
                <label>Keywords</label>
                <input type="text" name="keywords" class="form-control">
            </div>

            <div class="col-md-6 mb-2">
                <label>Category</label>
                <input type="text" name="category" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label>Profile Image</label>
                <input type="file" name="profile_image" class="form-control">
                @if($user->getFirstMediaUrl('profile_image'))
                    <img src="{{ $user->getFirstMediaUrl('profile_image') }}" class="mt-2 rounded-circle" width="100" height="100">
                @endif
            </div>

            <div class="col-md-12 mb-3">
                <label>Upload Paper (PDF/DOC, max 10MB)</label>
                <input type="file" name="file_upload" class="form-control">
                @if($user->getFirstMediaUrl('paper_upload'))
                    <a href="{{ $user->getFirstMediaUrl('paper_upload') }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">View Uploaded File</a>
                @endif
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Changes</button>
    </form>
</div>
@endsection
