@extends('admin.layouts.master')

@section('title', 'Categories')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>All Categories</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th style="width:180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $key => $cat)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $cat->name }}</td>
                        
                        {{-- Truncate description with modal --}}
                        <td style="max-width:300px; word-wrap:break-word;">
                            @if(Str::length($cat->description) > 50)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#descModal{{ $cat->id }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($cat->description, 50, '...') }}
                                </a>

                                {{-- Modal --}}
                                <div class="modal fade" id="descModal{{ $cat->id }}" tabindex="-1" aria-labelledby="descModalLabel{{ $cat->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="descModalLabel{{ $cat->id }}">Full Description</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $cat->description }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{ $cat->description }}
                            @endif
                        </td>

                    <td class="text-center">
    {{-- View --}}
    <a href="{{ route('admin.categories.show', encrypt($cat->id)) }}" class="btn btn-info btn-sm me-1">
        <i class="fa fa-eye"></i>
    </a>

    {{-- Edit --}}
    <a href="{{ route('admin.categories.edit', encrypt($cat->id)) }}" class="btn btn-warning btn-sm me-1">
        <i class="fa fa-pen"></i>
    </a>

    {{-- Delete --}}
    <form action="{{ route('admin.categories.destroy', encrypt($cat->id)) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure you want to delete this category?')">
            <i class="fa fa-trash"></i>
        </button>
    </form>
</td>

                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
