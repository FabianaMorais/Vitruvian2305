@extends('base.page_public')

@section('content')

<div class="row mb-4">
    <div class="col-12 px-4 text-center">
        <h1 class="h1 vpg-title">@lang('pgs_public.MOBILE_APP_TTL')</h1>
    </div>
</div>

{{-- charts --}}
<div class="row justify-content-center">
    <div class="col-8 px-0 py-4 text-center order-2
                col-sm-7 p-sm-4
                col-md-5 offset-md-1 text-md-left order-md-1
                col-lg-5 offset-lg-0
                col-xl-4
                col-vcenter">
        <h2 class="h2 vpg-desc">@lang('pgs_public.MOBILE_APP_DESC_1')</h2> 
    </div>
    <div class="col-8 px-0 py-4 order-1
                col-sm-7 p-sm-4
                col-md-6 order-md-2
                col-lg-5
                col-xl-4
                text-center">
        <img style="width: auto; max-height: 300px;" src="{{asset('images/public_pages/mobile_app/app_charts.png')}}">
    </div>
</div>
{{-- charts --}}


{{-- medication --}}
<div class="row justify-content-center vstyle-dark">
    <div class="col-8 px-0 py-4
                col-sm-7 p-sm-4
                col-md-6
                col-lg-5
                col-xl-4
                text-center">
        <img style="width: auto; max-height: 300px;" src="{{asset('images/public_pages/mobile_app/app_med.png')}}">
    </div>
    <div class="col-8 px-0 py-4 text-center
                col-sm-7 p-sm-4
                col-md-5 text-md-left
                col-lg-5 
                col-xl-4
                col-vcenter">
        <h2 class="h2 vpg-desc vtext-light">@lang('pgs_public.MOBILE_APP_DESC_2')</h2> 
    </div>
</div>
{{-- medication --}}


{{-- crisis --}}
<div class="row justify-content-center">
    <div class="col-8 px-0 py-4 text-center order-2
                col-sm-7 p-sm-4
                col-md-5 offset-md-1 text-md-left order-md-1
                col-lg-5 offset-lg-0
                col-xl-4
                col-vcenter">
        <h2 class="h2 vpg-desc">@lang('pgs_public.MOBILE_APP_DESC_3')</h2> 
    </div>
    <div class="col-8 px-0 py-4 order-1
                col-sm-7 p-sm-4
                col-md-6 order-md-2
                col-lg-5
                col-xl-4
                text-center">
        <img style="width: auto; max-height: 300px;" src="{{asset('images/public_pages/mobile_app/app_crisis.png')}}">
    </div>
</div>
{{-- crisis --}}


{{-- assistance --}}
<div class="row justify-content-center vstyle-dark">
    <div class="col-8 px-0 py-4
                col-sm-7 p-sm-4
                col-md-6
                col-lg-5
                col-xl-4
                text-center">
        <img style="width: auto; max-height: 300px;" src="{{asset('images/public_pages/mobile_app/app_assistance.png')}}">
    </div>
    <div class="col-8 px-0 py-4 text-center
                col-sm-7 p-sm-4
                col-md-5 text-md-left
                col-lg-5 
                col-xl-4
                col-vcenter">
        <h2 class="h2 vpg-desc vtext-light">@lang('pgs_public.MOBILE_APP_DESC_4')</h2> 
    </div>
</div>
{{-- assistance --}}


{{-- appointments --}}
<div class="row justify-content-center">
    <div class="col-8 px-0 py-4 text-center order-2
                col-sm-7 p-sm-4
                col-md-5 offset-md-1 text-md-left order-md-1
                col-lg-5 offset-lg-0
                col-xl-4
                col-vcenter">
        <h2 class="h2 vpg-desc">@lang('pgs_public.MOBILE_APP_DESC_5')</h2> 
    </div>
    <div class="col-8 px-0 py-4 order-1
                col-sm-7 p-sm-4
                col-md-6 order-md-2
                col-lg-5
                col-xl-4
                text-center">
        <img style="width: auto; max-height: 300px;" src="{{asset('images/public_pages/mobile_app/pro.png')}}">
    </div>
</div>
{{-- appointments --}}

@endsection