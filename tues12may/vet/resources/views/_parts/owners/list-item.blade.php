<a href="/owners/{{$owner->id}}" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
        <div class="d-flex flex-column">
            <h5 class="mb-3">{{ $owner->fullName() }}</h5>
            <h6>Customer since: {{ $owner->customerSince()}}</h6>
            <p>Added by: {{ $owner->createdBy() }}</p>
        </div>
        <div class="d-flex flex-column align-items-end">
            <p> {{ $owner->fullAddress() }}</p>
            <p> {{ $owner->formattedPhoneNumber() }}</p>
        </div>
    </div>
</a>