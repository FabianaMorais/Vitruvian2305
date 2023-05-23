<input id="amr_entry_key" type="hidden" value="{{$user_info->id}}">

<div class="row justify-content-center">
    <div class="col-auto col-vcenter">
        <h1><i class="vicon-doc fas fa-user-md"></i></h1>
    </div>
    <div class="col-auto col-vcenter">
        <h4 class="h4">{{$user_info->full_name}}</h4>
    </div>
</div>

<div class="row my-2">
    <div class="col-4 text-right">
        <h6 class="h6 text-muted">@lang('pg_manage_regs.USERNAME'):</h6>
    </div>
    <div class="col-8">
        <h6 class="h6 text-break">{{$user_info->username}}</h6>
    </div>
</div>

<div class="row my-2">
    <div class="col-4 text-right">
        <h6 class="h6 text-muted">@lang('pg_manage_regs.ROLE'):</h6>
    </div>
    <div class="col-8">
        <h6 class="h6 text-break">{{$user_info->role}}</h6>
    </div>
</div>

<div class="row my-2">
    <div class="col-4 text-right">
        <h6 class="h6 text-muted">@lang('pg_manage_regs.EMAIL'):</h6>
    </div>
    <div class="col-8">
        <h6 class="h6 text-break">{{$user_info->email}}</h6>
    </div>
</div>

<div class="row my-2">
    <div class="col-4 text-right">
        <h6 class="h6 text-muted">@lang('pg_manage_regs.PHONE'):</h6>
    </div>
    <div class="col-8">
        <h6 class="h6 text-break">{{$user_info->phone}}</h6>
    </div>
</div>

<div class="row my-2">
    <div class="col-4 text-right">
        <h6 class="h6 text-muted">@lang('pg_manage_regs.ADDRESS'):</h6>
    </div>
    <div class="col-8">
        <h6 class="h6 text-break">{{$user_info->address}}</h6>
    </div>
</div>

<div class="row my-2">
    <div class="col-4 text-right">
        <h6 class="h6 text-muted">@lang('pg_manage_regs.ORGANIZATION_NAME'):</h6>
    </div>
    <div class="col-8">
        <h6 class="h6 text-break">{{$user_info->organization_name}}</h6>
    </div>
</div>

<div class="row my-2">
    <div class="col-4 text-right">
        <h6 class="h6 text-muted">@lang('pg_manage_regs.REGISTERED_AT'):</h6>
    </div>
    <div class="col-8">
        <h6 class="h6 text-break">{{$user_info->registered_at}}</h6>
    </div>
</div>

<div class="row">
    <div class="col-12 text-center mt-2
                col-sm-6 text-sm-right">
        <button type="button" class="btn vbtn-main" data-toggle="modal" data-target="#md_amd_confirm_accept">
            @lang('pg_manage_regs.ACCEPT_REG')
        </button>
    </div>
    <div class="col-12 text-center mt-2
                col-sm-6 text-sm-left">
        <button type="button" class="btn vbtn-negative" data-toggle="modal" data-target="#md_amd_confirm_refuse">
            @lang('pg_manage_regs.REJECT_REG')
        </button>
    </div>
</div>


