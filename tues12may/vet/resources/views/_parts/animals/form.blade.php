<div class="container col-md-8 border border-secondary rounded mb-4">
    <h4 class="display-6 p-2 border-bottom">Add An Animal</h4>
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
            <div class="form-group col-md-4">
                <label for="date_of_birth">Date Of Birth</label>
                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') {{-- ? old('date_of_birth') : $animal->date_of_birth --}} }}">
                @error('date_of_birth')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                @enderror
            </div>
            
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="type">Type</label>
                <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type') {{-- ? old('type') : $animal->type  --}}}}" placeholder="Donkey" required>
                @error('type')
                    <p class="invalid-feedback">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <label for="biteyness">Biteyness</label>
                <input type="number" class="form-control @error('biteyness') is-invalid @enderror" id="biteyness" name="biteyness" value="{{ old('biteyness') {{-- ? old('biteyness') : $animal->biteyness  --}}}}" placeholder="1-5" min="1" max="5" step="1" required>
                @error('biteyness')
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
                <label for="height">Height (m)</label>
                <input type="number" class="form-control @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height') {{-- ? old('height') : $animal->height --}} }}" placeholder="" step="0.01" required>
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