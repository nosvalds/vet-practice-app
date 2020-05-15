<a href="#{{-- /owners/{{$owner->id}} --}}" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
        <div class="d-flex flex-column">
            <h5 class="mb-3">{{ $animal->name }}</h5>
            <h6>Age {{ $animal->age() }}</h6>
        </div>
        <div class="d-flex flex-column align-items-end">
            <p>{{ $animal->type }}</p>
            <p>{{ $animal->weight }}kg</p>
            <p>{{ $animal->height }}m</p>
            <p>Biteyness:{{ $animal->biteyness }}</p>
        </div>
    </div>
</a>