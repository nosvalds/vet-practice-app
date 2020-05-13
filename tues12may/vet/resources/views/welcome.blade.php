@extends('app');

@section('title'){{
    "Wildlife Supreme - $page"
}}@endsection

@section('welcome')
    <h1>Welcome to Wildlife Supremes Vet Service</h1>
    <h2>{{ $page }}:</h2>

    @if ($page === 'Home')
        <h2>Good {{ $timeOfDay }}!</h2>
    @elseif ($page === 'Owner')
        @include("_parts/owners/list-item", ["owner" => $owner]) 
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
                {{ $owners->links() }}
            </div>
        @endif
    @endif
    
    
@endsection