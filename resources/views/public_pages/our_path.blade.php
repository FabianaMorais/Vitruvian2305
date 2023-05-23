@extends('base.page_public')

@section('content')
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.OUR_PATH_TTL')</h1>
        </div>
    </div>

    {{-- quality of life--}}
    <div class="row justify-content-center py-5">
        <div class="col-8 px-0 py-4 text-center order-2
                    col-sm-7 p-sm-4
                    col-md-5 offset-md-1 text-md-left order-md-1
                    col-lg-5 offset-lg-0
                    col-xl-4
                    col-vcenter">
            <h2 class="h2 vpg-subtitle">@lang('pgs_public.OUR_VISION_QUALITY_OF_LIFE_TTL')</h2>
            <h4 class="h4 vpg-desc">@lang('pgs_public.OUR_VISION_QUALITY_OF_LIFE_DESC')</h>
        </div>
        <div class="col-8 px-0 py-4 order-1
                    col-sm-7 p-sm-4
                    col-md-6 order-md-2
                    col-lg-5
                    col-xl-4
                    text-center">
            <img style="width: 80%; height: auto;" src="{{ asset('images/public_pages/our_vision/quality_of_life.svg') }}"> 
        </div>
    </div>
    {{-- quality of life--}}

    {{-- excelence --}}
    <div class="row justify-content-center py-5 vstyle-dark">
        <div class="col-8 px-0 py-4
                    col-sm-7 p-sm-4
                    col-md-6
                    col-lg-5
                    col-xl-4
                    text-center">
            <img style="width: 80%; height: auto;" src="{{ asset('images/public_pages/our_vision/excelence.svg') }}"> 
        </div>
        <div class="col-8 px-0 py-4 text-center
                    col-sm-7 p-sm-4
                    col-md-5 text-md-left
                    col-lg-5 
                    col-xl-4
                    col-vcenter">
            <h2 class="h2 vpg-subtitle vtext-light">@lang('pgs_public.OUR_VISION_EXCELENCE_TTL')</h2> 
            <h4 class="h4 vpg-desc vtext-light">@lang('pgs_public.OUR_VISION_EXCELENCE_DESC')</h4> 
        </div>
    </div>
    {{-- excelence --}}

    {{-- treatment success --}}
    <div class="row justify-content-center py-5">
        <div class="col-8 px-0 py-4 text-center order-2
                    col-sm-7 p-sm-4
                    col-md-5 offset-md-1 text-md-left order-md-1
                    col-lg-5 offset-lg-0
                    col-xl-4
                    col-vcenter">
            <h2 class="h2 vpg-subtitle">@lang('pgs_public.OUR_VISION_TREATMENT_SUCCESS_TTL')</h2> 
            <h4 class="h4 vpg-desc">@lang('pgs_public.OUR_VISION_TREATMENT_SUCCESS_DESC')</h4> 
        </div>
        <div class="col-8 px-0 py-4 order-1
                    col-sm-7 p-sm-4
                    col-md-6 order-md-2
                    col-lg-5
                    col-xl-4
                    text-center">
            <img style="width: 80%; height: auto;;" src="{{ asset('images/public_pages/our_vision/treatment_success.svg') }}"> 
        </div>
    </div>
    {{-- treatment success --}}

    {{-- save lives --}}
    <div class="row justify-content-center py-5 vstyle-dark">
        <div class="col-8 px-0 py-4
                    col-sm-7 p-sm-4
                    col-md-6
                    col-lg-5
                    col-xl-4
                    text-center">
            <img style="width: 80%; height: auto;" src="{{ asset('images/public_pages/our_vision/saving_lives.svg') }}"> 
        </div>
        <div class="col-8 px-0 py-4 text-center
                    col-sm-7 p-sm-4
                    col-md-5 text-md-left
                    col-lg-5 
                    col-xl-4
                    col-vcenter">
            <h2 class="h2 vpg-subtitle vtext-light">@lang('pgs_public.OUR_VISION_SAVE_LIVES_TTL')</h2> 
            <h4 class="h4 vpg-desc vtext-light">@lang('pgs_public.OUR_VISION_SAVE_LIVES_DESC')</h4> 
        </div>
    </div>
    {{-- save lives --}}

@endsection