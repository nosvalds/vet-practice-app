<a href="/owners/{{$owner->id}}" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">{{ $owner->fullName() }}</h5>
        <div class="d-flex flex-column align-items-end">
            <p> {{ $owner->fullAddress() }}</p>
            <p> {{ $owner->formattedPhoneNumber() }}</p>
        </div>
    </div>
</a>