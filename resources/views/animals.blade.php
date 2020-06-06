@extends('app')

@section('title'){{
    "Wildlife Supreme - $page"
}}@endsection

@section('content')
    <div class="container mb-4">
        <h3 class="list-group-item active display-5">{{ $page }}</h3>
        @if ($page === 'Animal')
            @include("_parts/animals/list-item", ["animal" => $animal])
    </div>
    <div class="container mb-4">
            <h3 class="list-group-item active display-5">Owner</h3>
            @include("_parts/owners/list-item", ["owner" => $owner]) 
    </div>
        @else
            @if ($animals->count() === 0)
                <h3 class="display-5">No animals found!</h3>
            @else
                <div class="container d-flex justify-content-center">
                    {{-- Pagination Links --}}
                    {{ $animals->withQueryString()->links() }}
                </div>
                
                @foreach ($animals as $animal)
                    @include("_parts/animals/list-item", ["animal" => $animal])
                @endforeach
                
                <div class="container d-flex justify-content-center mt-2">
                    {{-- Pagination Links --}}
                    {{ $animals->withQueryString()->links() }}
                </div>
            @endif
    </div>
        @endif
@endsection