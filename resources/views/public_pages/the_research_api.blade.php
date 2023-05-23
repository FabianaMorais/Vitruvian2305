@extends('base.page_public')

@section('content')
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.RESEARCH_API_TTL')</h1>
        </div>
    </div>

    <div class="row justify-content-center" style="min-height:30vh;" >
        <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-vcenter order-2 order-md-1 mt-4 mt-md-0">
            <div class="row">
                <div class="col-12 text-center text-md-left ">
                    <h2 class="h2 vpg-desc">@lang('pgs_public.RESEARCH_API_INTRO')</h2>
                </div>
                <div class="col-12 text-center text-md-right">
                    <a href="{{ route('public_api.docs') }}" class="btn vbtn-main vbtn-large">@lang('pgs_public.KNOW_MORE_BUTTON')</a>
                </div>
            </div>
        </div>
        <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-vcenter order-1 order-md-2">
            <img class="mx-auto" src="{{ asset('images/public_pages/research_api/research_api.svg') }}" style="width:90%;height:auto;">
        </div>
    </div>

    <div class="row justify-content-center mt-5 py-5" style="min-height:30vh;" >
        <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-vcenter ">
            <img class="mx-auto" src="{{ asset('images/public_pages/research_api/security.svg') }}" style="width:80%;height:auto;">
        </div>
        <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4  col-vcenter mt-4 mt-md-0">
            <div class="row">
                <div class="col-12 text-center text-md-left ">
                    <h2 class="h2 vpg-desc">@lang('pgs_public.RESEARCH_API_SECURITY')</h2>
                </div>
            </div>
        </div>
    </div>

@endsection