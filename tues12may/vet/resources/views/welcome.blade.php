@extends('app');

@section('title'){{
    "Wildlife Supreme - Owners"
}}@endsection

@section('welcome')
    <h1>Welcome to Wildlife Supreme's Vet Service</h1>

    <h2>Owners</h2>
    
    @foreach (App\Owner::all() as $owner)
        {{-- pass-through $owner as "owner" --}}
        @include("_parts/owners/list-item", ["owner" => $owner])
    @endforeach
    
@endsection