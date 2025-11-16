@extends('admin.layouts.master')
@section('title','Bookmarks')
@section('content')

<h3 class="mb-3">My Bookmarks</h3>

@if($bookmarks->isEmpty())
    <p class="text-muted">No bookmarks found.</p>
@else
    <div class="row g-3">
        @foreach($bookmarks as $research)
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold">{{ $research->title }}</h5>
                <p class="mb-1"><strong>Author:</strong> {{ $research->author->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>University:</strong> {{ $research->publisher->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Category:</strong> {{ implode(', ', $research->category_names) }}</p>
                <div class="d-flex justify-content-between mt-2">
                    <a href="{{ route('admin.researches.show', $research->id) }}" class="btn btn-sm btn-primary">View Paper</a>
                    <button class="btn btn-sm btn-danger remove-bookmark" data-id="{{ $research->id }}">Remove</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

<script>
    document.querySelectorAll('.remove-bookmark').forEach(btn => {
        btn.addEventListener('click', function() {
            const researchId = this.dataset.id;
            fetch("{{ url('admin/bookmark/toggle') }}/"+researchId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json()).then(data => {
                alert(data.message);
                location.reload();
            });
        });
    });
</script>

@endsection
