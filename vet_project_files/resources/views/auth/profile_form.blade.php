@extends('app');

@section('title'){{
    "Wildlife Supreme - $page"
}}@endsection

@section('content')
<div class="container col-md-8 border border-secondary rounded mb-4">
    <h4 class="display-6 p-2 border-bottom">Edit Profile</h4>
    <form method="post">
        @csrf {{-- security feature --}}
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') {{-- ? old('name') : $animal->name  --}}}}" placeholder="Scruffy" >
                @error('name')
                    <p class="invalid-feedback">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>      
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="email">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') {{-- ? old('email') : $animal->email  --}}}}" placeholder="greg@domain.com" required>
                @error('email')
                    <p class="invalid-feedback">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="password">Password</label>
                <input type="number" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') {{-- ? old('password') : $animal->password  --}}}}" placeholder="1-5" min="1" max="5" step="1" required>
                @error('password')
                    <p class="invalid-feedback">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="weight">Weight (kg)</label>
                <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') {{-- ? old('weight') : $animal->weight --}} }}" placeholder="" required>
                @error('weight')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="height">Height (cm)</label>
                <input type="number" class="form-control @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height') {{-- ? old('height') : $animal->height --}} }}" placeholder="" step="1" max="500" required>
                @error('height')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                @enderror
            </div>
        </div>
        
        <button type="submit" class="btn btn-secondary mb-2">Add Animal</button>
    </form>
</div>

@endsection