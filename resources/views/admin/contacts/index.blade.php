@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Contact Messages</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th style="width:180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>

                        {{-- Truncate subject if too long --}}
                        <td style="max-width:250px; word-wrap:break-word;">
                            @if(Str::length($contact->subject ?? '') > 30)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#subjectModal{{ $contact->id }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($contact->subject, 30, '...') }}
                                </a>

                                {{-- Modal --}}
                                <div class="modal fade" id="subjectModal{{ $contact->id }}" tabindex="-1" aria-labelledby="subjectModalLabel{{ $contact->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="subjectModalLabel{{ $contact->id }}">Full Subject</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $contact->subject }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{ $contact->subject ?? 'N/A' }}
                            @endif
                        </td>

                        <td>{{ $contact->created_at->format('d M Y') }}</td>

                        {{-- Actions with icons --}}
                        <td class="text-center">
                            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-info btn-sm me-1">
                                <i class="fa fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this message?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $contacts->links() }}
        </div>
    </div>
</div>
@endsection
