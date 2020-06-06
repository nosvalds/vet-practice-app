@extends('app')

@section('title'){{
    "Wildlife Supreme - $page"
}}@endsection

@section('content')
    @if ($page === 'Home')
        <h2 class="text-center text-primary pb-4">Good {{ $timeOfDay }} {{$user->name}}!</h2>
        <div class="container">
            <img class="rounded mx-auto d-block img-fluid" src="https://www.tokkoro.com/picsup/2839685-namibia-africa-nature-landscape-trees-savannah-shrubs-sunset___landscape-nature-wallpapers.jpg" alt="placeholder kitten">
        </div>
    @elseif ($page === 'Owner')
        <div class="container mb-2">
            <h3 class="list-group-item active display-5">{{ $page }}</h3>
            @include("_parts/owners/list-item", ["owner" => $owner]) 
        </div>

        <div class="btn-group d-block text-center mb-4" role="group" aria-label="Add Modify buttons">
            <a class="btn btn-secondary" href="/owners/edit/{{ $owner->id }}" role="button">Modify Owner<a>
            <a class="btn btn-secondary" href="/owners/create" role="button">Add New Owner</a>
        </div>

        <div class="container mb-4">
            <h3 class="list-group-item active display-5 rounded-top">Animals</h3>
            @if ($owner->animals->count() === 0)
                <h4>This owner does not have any animals</h4>
            @else
                @foreach ($owner->animals as $animal)
                    @include("_parts/animals/list-item", ["animal" => $animal])
                @endforeach
            @endif
        </div>
        @include("_parts/animals/form", ["owner" => $owner])
    @else
        @if ($owners->count() === 0)
            <h3 class="mb-2">No owners found!</h3>
        @else
            <div class="container mb-2">
                <h2 class="list-group-item active display-5">{{ $page }} </h2>
                <div class="container d-flex justify-content-center">
                    {{ $owners->withQueryString()->links() }}
                </div>
                @foreach ($owners as $owner)
                    {{-- pass-through $owner as "owner" --}}
                    @include("_parts/owners/list-item", ["owner" => $owner])
                @endforeach
            </div>
            <div class="container d-flex justify-content-center">
                {{-- Pagination Links --}}
                {{ $owners->withQueryString()->links() }}
            </div>
        @endif
        <div class="container d-flex justify-content-center mb-4">
            <a class="btn btn-secondary" href="/owners/create" role="button">Add New Owner</a>
        </div>
        
    @endif

    
@endsection