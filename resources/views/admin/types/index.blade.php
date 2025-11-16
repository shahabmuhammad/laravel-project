@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Research Types</h2>
    <a href="{{ route('admin.types.create') }}" class="btn btn-primary mb-3">+ Add Type</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th style="width:180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($types as $type)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $type->type }}</td>

                        {{-- Truncate description with modal --}}
                        <td style="max-width:300px; word-wrap:break-word;">
                            @if(Str::length($type->description) > 50)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#descModal{{ $type->id }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($type->description, 50, '...') }}
                                </a>

                                {{-- Modal --}}
                                <div class="modal fade" id="descModal{{ $type->id }}" tabindex="-1" aria-labelledby="descModalLabel{{ $type->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="descModalLabel{{ $type->id }}">Full Description</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $type->description }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{ $type->description }}
                            @endif
                        </td>

                        {{-- Actions with icons --}}
                        <td class="text-center">
                            <a href="{{ route('admin.types.show', encrypt($type->id)) }}" class="btn btn-info btn-sm me-1">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.types.edit', encrypt($type->id)) }}" class="btn btn-warning btn-sm me-1">
                                <i class="fa fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.types.destroy', encrypt($type->id)) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this type?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
