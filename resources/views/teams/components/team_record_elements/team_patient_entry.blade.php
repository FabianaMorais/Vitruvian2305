<div class="list-group-item list-group-item-action py-1" style="cursor: pointer">
    <div class="row">
        <div class="col-auto col-vcenter">
            <img class="rounded-circle my-1" style="width: 40px; height: 40px; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $pat->avatar) }}">
        </div>
        <div class="col col-vcenter pl-0 font-weight-normal">
            {{ $pat->name }}
        </div>
    </div>
</div>