@extends('admin.layouts.master')

@section('title', 'Research Management')

@section('content')
<div class="container mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{ $user->hasRole('User') ? 'Browse Research Papers' : 'All Research Papers' }}</h3>

        @unless($user->hasRole('User'))
            <a href="{{ route('admin.researches.create') }}" class="btn btn-primary">+ Add New</a>
        @endunless
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Search Bar --}}
    <form method="GET" class="row g-2 mb-3" style="max-width: 500px;">
        <div class="col">
            <input type="text" name="search" class="form-control"
                   placeholder="Search by title, author, or keyword..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary"><i class="fa fa-search"></i></button>
        </div>
        @if(request('search'))
            <div class="col-auto">
                <a href="{{ route('admin.researches.index') }}" class="btn btn-outline-danger">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        @endif
    </form>

    {{-- Research Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Publisher</th>
                    <th>Type</th>
                    <th>Keywords</th>
                    <th>Status</th>
                    <th>Downloads</th>
                   <th>File</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($researches as $index => $r)
                    <tr>
                        <td>{{ $researches->firstItem() + $index }}</td>
                        <td>
                            @if(Str::length($r->title) > 50)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#titleModal{{ $r->id }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($r->title, 50, '...') }}
                                </a>

                                {{-- Title Modal --}}
                                <div class="modal fade" id="titleModal{{ $r->id }}" tabindex="-1" aria-labelledby="titleModalLabel{{ $r->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="titleModalLabel{{ $r->id }}">Full Title</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">{{ $r->title }}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{ $r->title }}
                            @endif
                        </td>

                        <td>{{ $r->author?->name ?? $r->user?->name ?? '—' }}</td>
                        <td>
                            @if(!empty($r->getCategoryNamesAttribute()))
                                {{ implode(', ', $r->getCategoryNamesAttribute()) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $r->publisher->name ?? '-' }}</td>
                        <td>{{ $r->type->type ?? '-' }}</td>

                        {{-- Keywords --}}
                        <td class="text-wrap" style="max-width: 200px;">
                            @if($r->keywords)
                                @foreach(explode(',', $r->keywords) as $keyword)
                                    <a href="{{ route('admin.researches.index', ['search' => trim($keyword)]) }}"
                                       class="badge bg-light text-dark border border-secondary-subtle me-1 mb-1">
                                       #{{ trim($keyword) }}
                                    </a>
                                @endforeach
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- Status --}}
                         <td class="text-center">
                                        @if ($user->hasRole('Admin'))
                                            <form method="POST" id="statusForm-{{ $r->id }}">
                                                @csrf
                                                <select name="status"
                                                    class="form-select form-select-sm text-center fw-semibold border-secondary-subtle"
                                                    style="min-width: 130px;"
                                                    onchange="
                                                    this.form.action = this.value === 'published'
                                                        ? '{{ route('admin.researches.approve', $r->id) }}'
                                                        : '{{ route('admin.researches.reject', $r->id) }}';
                                                    this.form.submit();
                                                ">
                                                    <option value="submitted"
                                                        {{ $r->status === 'submitted' ? 'selected' : '' }}>Pending</option>
                                                    <option value="published"
                                                        {{ $r->status === 'published' ? 'selected' : '' }}>Published
                                                    </option>
                                                    <option value="rejected"
                                                        {{ $r->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </form>
                                        @else
                                            <span
                                                class="badge
                                            @if ($r->status === 'published') bg-success
                                            @elseif($r->status === 'submitted') bg-warning
                                            @elseif($r->status === 'rejected') bg-danger
                                            @else bg-secondary @endif">
                                                {{ ucfirst($r->status) }}
                                            </span>
                                        @endif
                                    </td>

                      <td class="text-center text-nowrap fw-semibold" style="width:60px;">
    {{ $r->downloads ?? 0 }}
</td>

<td class="text-center text-nowrap" style="width:60px;">
    @if($r->hasMedia('research_files'))
        @php
            $file = $r->getFirstMedia('research_files');
        @endphp
        <a href="{{ asset('media/' . $file->id . '/' . $file->file_name) }}" class="btn btn-success btn-sm p-1" target="_blank">
            <i class="fa fa-download"></i>
        </a>
    @else
        <span class="text-muted">-</span>
    @endif
</td>



                        
                       {{-- Actions --}}
<td class="text-center text-nowrap">
    <div class="d-flex justify-content-center gap-1">
        <a href="{{ route('admin.researches.show', encrypt($r->id)) }}" class="btn btn-info btn-sm">
            <i class="fa fa-eye"></i>
        </a>

        @unless($user->hasRole('User'))
            <a href="{{ route('admin.researches.edit', encrypt($r->id)) }}" class="btn btn-warning btn-sm">
                <i class="fa fa-pen"></i>
            </a>

            <form action="{{ route('admin.researches.destroy', encrypt($r->id)) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this research?')">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        @endunless
    </div>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted py-4">
                            <i class="fa fa-inbox me-1"></i> No research found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $researches->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
