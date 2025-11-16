@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold">
                 Role Management
            </h2>

            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary-custom shadow-sm">
                <i class="fa fa-plus me-1"></i> Create New Role
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
                        <tr>
                            <th width="100px">No</th>
                            <th>Name</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm"
                                        href="{{ route('admin.roles.show', Crypt::encrypt($role->id)) }}"><i
                                            class="fa fa-eye"></i></a>
                                    @can('role-edit')
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('admin.roles.edit', Crypt::encrypt($role->id)) }}"><i
                                                class="fa fa-pen"></i></a>
                                    @endcan

                                    @can('role-delete')
                                        <form method="POST"
                                            action="{{ route('admin.roles.destroy', Crypt::encrypt($role->id)) }}"
                                            style="display:inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {!! $roles->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
