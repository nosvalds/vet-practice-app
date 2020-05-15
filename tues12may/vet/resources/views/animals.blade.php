@extends('app')

@section('title'){{
    "Wildlife Supreme - $page"
}}@endsection

@section('content')
    <h2>{{ $page }}</h2>
    @if ($page === 'Animal')
        @include("_parts/animals/list-item", ["animal" => $animal])
        <h2>Owner</h2>
        @include("_parts/owners/list-item", ["owner" => $owner]) 
    @else
        @if ($animals->count() === 0)
            <h3>No animals found!</h3>
        @else
            <div class="container">
                @foreach ($animals as $animal)
                    @include("_parts/animals/list-item", ["animal" => $animal])
                @endforeach
            </div>
            <div class="container">
                {{-- Pagination Links --}}
                {{ $animals->withQueryString()->links() }}
            </div>
        @endif
    @endif
@endsection