@extends('admin.layouts.master')
@section('title','Bookmarks')
@section('content')

<h3 class="mb-3">My Bookmarks</h3>

@if($bookmarks->isEmpty())
    <p class="text-muted">No bookmarks found.</p>
@else
    <div class="row g-3">
        @foreach($bookmarks as $paper)
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold">{{ $paper->title }}</h5>
                <p class="mb-1"><strong>Author:</strong> {{ $paper->author->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>University:</strong> {{ $paper->publisher->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Category:</strong> {{ implode(', ', $paper->category_names) }}</p>
                <div class="d-flex justify-content-between mt-2">
                    <a href="{{ route('admin.researches.show', $paper->id) }}" class="btn btn-sm btn-primary">View Paper</a>
                    <button class="btn btn-sm bookmark-btn" data-id="{{ $paper->id }}">
                        <i class="bi bi-bookmark-fill text-primary fs-5"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

<script>
document.querySelectorAll('.bookmark-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const icon = this.querySelector('i');

        fetch("{{ url('admin/bookmark/toggle') }}/" + id, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            // Toggle icon instantly
            if (icon.classList.contains('bi-bookmark')) {
                icon.classList.remove('bi-bookmark', 'text-muted');
                icon.classList.add('bi-bookmark-fill', 'text-primary');
            } else {
                icon.classList.remove('bi-bookmark-fill', 'text-primary');
                icon.classList.add('bi-bookmark', 'text-muted');
                // Remove card from DOM when un-bookmarked
                this.closest('.col-md-4').remove();
            }
            console.log(data.message);
        });
    });
});
</script>

@endsection
