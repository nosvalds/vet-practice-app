@extends('app');

@section('title'){{
    "Wildlife Supreme - $page"
}}@endsection

@section('content')
    <div class="container col-md-10 border border-secondary rounded mb-4">
        <h2 class="display-4 p-2 border-bottom">{{ $page }}</h2>    
        <form method="post" action="/owners/{{ $page === "Modify Owner" ? "edit/".$owner->id : "create" }}">
            @csrf {{-- security feature --}}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') ? old('first_name') : $owner->first_name }}" placeholder="Joe" >
                    @error('first_name')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') ? old('last_name') : $owner->last_name }}" placeholder="Exotic">
                    @error('last_name')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="telephone">Telephone</label>
                    <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone') ? old('telephone') : $owner->telephone }}" placeholder="+44 4324 884 224">
                    @error('telephone')
                            <p class="invalid-feedback">
                                {{ $message }}
                            </p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="address_1">Address 1</label>
                <input type="text" class="form-control @error('address_1') is-invalid @enderror" id="address_1" name="address_1" value="{{ old('address_1') ? old('address_1') : $owner->address_1 }}" placeholder="1234 Main St">
                @error('address_1')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="address_2">Address 2</label>
                <input type="text" class="form-control @error('address_2') is-invalid @enderror" id="address_2" name="address_2" value="{{ old('address_2') ? old('address_2') : $owner->address_2 }}" placeholder="Apartment, studio, or floor">
                @error('address_2')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="town">Town</label>
                    <input type="text" class="form-control @error('town') is-invalid @enderror" id="town" name="town" value="{{ old('town') ? old('town') : $owner->town }}" placeholder="Funkytown">
                    @error('town')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <div class="form-group col-md-4">
                    <label for="postcode">Postcode</label>
                    <input type="text" class="form-control @error('postcode') is-invalid @enderror" id="postcode" name="postcode" value="{{ old('postcode') ? old('postcode') : $owner->postcode }}">
                    @error('postcode')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ $page === "Modify Owner" ? "Submit Change" : $page }}</button>
        </form>
    </div>
@endsection