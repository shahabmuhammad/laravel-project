@extends('front.layouts.master')

@section('title', 'Home | Research Repository')

@section('content')

 <!-- ===== SEARCH BAR ===== -->
    <section class="search-bar text-center my-4">
        <div class="container">
            <form action="{{ route('search') }}" method="GET">
            <div class="input-group shadow-sm mx-auto" style="max-width:600px;">
                <input type="text" class="form-control" name="query" value="{{ request('query') }}" placeholder="Search by title, author or keyword">
                <button type="submit" class="btn btn-primary-custom px-4">Search</button>
            </div>
            </form>
        </div>
    </section>

@if(isset($results))
    <h3>Search Results:</h3>
    @if($results->count())
        <ul>
            @foreach($results as $item)
                <li>{{ $item->title }}</li>
                <li>{{ $item->keyword}}</li>
                <li>{{ $item->description }}</li>
            @endforeach
        </ul>
    @else
        <p>No results found.</p>
    @endif
@endif
@endsection