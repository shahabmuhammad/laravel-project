@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold">
                Users Management
            </h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary-custom shadow-sm">
                 Create New User
            </a>
        </div>

        {{-- Success Alert --}}
        @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
               {{ $value }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endsession

        {{-- Card --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px;">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Roles</th>
                                <th scope="col" class="text-center" style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td class="fw-semibold">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @forelse ($user->getRoleNames() as $role)
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle me-1">
                                                {{ $role }}
                                            </span>
                                        @empty
                                            <span class="text-muted fst-italic">No roles</span>
                                        @endforelse
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.users.show', encrypt($user->id)) }}"
                                            class="btn btn-warning btn-sm me-1">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', encrypt($user->id)) }}"
                                            class="btn btn-primary btn-sm me-1">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', encrypt($user->id)) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {!! $data->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
