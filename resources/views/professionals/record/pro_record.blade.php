<div class="row justify-content-center">
    <div class="col-auto
                col-vcenter">
        <img class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $pro_entry->avatar ) }}">
    </div>
    <div class="col-12 text-center
                col-md text-md-left
                col-vcenter">
        <h2 class="h2">{{ $pro_entry->full_name }}</h2>
        <h5 class="h5"><i>{{ $pro_entry->role }}</i></h5>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('record_pro.ACCOUNT_INFO_TITLE')</h6>
        <hr class="mt-1">
    </div>

    <div class="col-12">
        <h6 class="h6 font-weight-light">@lang('record_pro.USERNAME')</h6>
    </div>

    <div class="col-12">
        <h6 class="h6">{{ $pro_entry->username }}</h6>
    </div>

    <div class="col-12 mt-3">
        <h6 class="h6 font-weight-light">@lang('record_pro.EMAIL')</h6>
    </div>

    <div class="col-12">
        <h6 class="h6">{{ $pro_entry->email }}</h6>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('record_pro.PRO_INFO_TITLE')</h6>
        <hr class="mt-1">
    </div>

    <div class="col-12">
        <h6 class="h6 font-weight-light">@lang('record_pro.PHONE')</h6>
    </div>

    <div class="col-12">
        <h6 class="h6">{{ $pro_entry->phone }}</h6>
    </div>

    <div class="col-12 mt-3">
        <h6 class="h6 font-weight-light">@lang('record_pro.ADDRESS')</h6>
    </div>

    <div class="col-12">
        <h6 class="h6">{{ $pro_entry->address }}</h6>
    </div>
</div>