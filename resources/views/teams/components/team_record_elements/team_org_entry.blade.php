<div class="list-group-item py-1 h-100">
    <div class="row h-100">
        <div class="col-auto col-vcenter">
            <img class="rounded-circle my-1" style="width: 60px; height: auto; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $org->avatar) }}">
        </div>
        <div class="col col-vcenter pl-0 text-break">
            {{ $org->name }}
        </div>
    </div>
</div>