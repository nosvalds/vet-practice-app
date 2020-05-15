@extends('app')

@section('title'){{
    "Wildlife Supreme - $page"
}}@endsection

@section('content')
    <h2>{{ $page }}</h2>

    @if ($page === 'Home')
        <h2>Good {{ $timeOfDay }}!</h2>
    @elseif ($page === 'Owner')
        @include("_parts/owners/list-item", ["owner" => $owner]) 
        <h2>Animals</h2>
        @if ($owner->animals->count() === 0)
            <h4>This owner does not have any animals</h4>
        @else
            @foreach ($owner->animals as $animal)
                @include("_parts/animals/list-item", ["animal" => $animal])
            @endforeach
        @endif
        @include("_parts/animals/form", ["owner" => $owner])
        <a class="btn btn-primary" href="/owners/edit/{{ $owner->id }}" role="button">Modify Owner<a>
    @else
        @if ($owners->count() === 0)
            <h3>No owners found!</h3>
        @else
            <div class="container">
                @foreach ($owners as $owner)
                    {{-- pass-through $owner as "owner" --}}
                    @include("_parts/owners/list-item", ["owner" => $owner])
                @endforeach
            </div>
            <div class="container">
                {{-- Pagination Links --}}
                {{ $owners->withQueryString()->links() }}
            </div>
        @endif
    @endif

    <a class="btn btn-primary" href="/owners/create" role="button">Add New Owner</a>
    
@endsection