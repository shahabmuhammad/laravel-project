@extends('admin.layouts.master')
@section('title', 'Admin Profile')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">Admin Profile</h3>
    <div class="card mb-4 p-3">
        <strong>Name:</strong> {{ $user->name }} <br>
        <strong>Email:</strong> {{ $user->email }}
    </div>

    <h5 class="mt-4 mb-3">All Users & Authors</h5>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->roles->pluck('name')->implode(', ') }}</td>
                    <td>
                        <a href="{{ route('admin.profiles.view', $u->id) }}" class="btn btn-sm btn-outline-primary">
                            View Profile
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
