@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Publishers</h2>
    <a href="{{ route('admin.publishers.create') }}" class="btn btn-primary mb-3">+ Add Publisher</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Name</th>
                    <th>Website</th>
                    <th>Address</th>
                    <th style="width:200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($publishers as $publisher)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $publisher->name }}</td>
                        
                        {{-- Website link with default blue/underline --}}
                        <td style="max-width:200px; word-wrap:break-word;">
                            <a href="{{ $publisher->website }}" target="_blank">
                                {{ Str::limit($publisher->website, 50, '...') }}
                            </a>
                        </td>
                        
                        {{-- Address link with no underline, black text --}}
                        <td style="max-width:200px; word-wrap:break-word;">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal{{ $publisher->id }}" class="text-decoration-none text-dark">
                                {{ Str::limit($publisher->address, 30, '...') }}
                            </a>

                            {{-- Modal for full address --}}
                            <div class="modal fade" id="addressModal{{ $publisher->id }}" tabindex="-1" aria-labelledby="addressModalLabel{{ $publisher->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addressModalLabel{{ $publisher->id }}">Full Address</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $publisher->address }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                     {{-- Actions --}}
<td class="text-center">
    <a href="{{ route('admin.publishers.show', encrypt($publisher->id)) }}"
       class="btn btn-info btn-sm me-1">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('admin.publishers.edit', encrypt($publisher->id)) }}"
       class="btn btn-warning btn-sm me-1">
        <i class="fa fa-pen"></i>
    </a>
    <form action="{{ route('admin.publishers.destroy', encrypt($publisher->id)) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure you want to delete this publisher?')">
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
