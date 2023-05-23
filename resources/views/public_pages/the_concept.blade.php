@extends('base.page_public')

@section('content')
    <div class="row">
        <div class="col-12 mb-4 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.CONCEPT_TTL')</h1>
        </div>
    </div>

    {{--first screen component --}}
    <div class="row justify-content-center mb-xl-5">
        <div class="col-10 text-center order-2
                    col-sm-7
                    col-md-5 text-md-left p-md-5 order-md-1
                    col-lg-5 p-lg-1
                    col-xl-4
                    col-vcenter">
            <h5 class="h5 vpg-desc">@lang('pgs_public.CONCEPT_HIGHLIGHT_TTL')</h5>
        </div>
        <div class="col-10 p-2 order-1
                    col-sm-6 p-sm-5
                    col-md-5 order-md-2
                    col-lg-4
                    col-xl-3 p-xl-3
                    col-vcenter">
            <img class="d-block mx-auto" style="width: 100%; height: auto;" src="{{ asset('images/public_pages/concept/concept.png') }}"> 
        </div>
    </div>

    {{-- concept cards --}}
    <div class="row justify-content-center
                mx-xl-5 px-xl-5">

        <div class="col-10 mt-5
                    col-sm-8
                    col-md-4
                    col-lg-4
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/concept/cloud.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.CONCEPT_FIRST_CARD_TEXT') @endslot
            @endcomponent
        </div>

        <div class="col-10 mt-5
                    col-sm-8
                    col-md-4
                    col-lg-4
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/concept/assistance.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.CONCEPT_SECOND_CARD_TEXT') @endslot
            @endcomponent
        </div>

        <div class="col-10 mt-5
                    col-sm-8
                    col-md-4
                    col-lg-4
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/concept/follow_up.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.CONCEPT_THIRD_CARD_TEXT') @endslot
            @endcomponent
        </div>

        <div class="col-10 mt-5
                    col-sm-8
                    col-md-4
                    col-lg-4
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/concept/efficience.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.CONCEPT_FOURTH_CARD_TEXT') @endslot
            @endcomponent
        </div>

        <div class="col-10 mt-5
                    col-sm-8
                    col-md-4
                    col-lg-4
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/concept/quality_of_life.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.CONCEPT_FIFTH_CARD_TEXT') @endslot
            @endcomponent
        </div>
        
    </div>

    <div class="row  my-5">
        <div class="col-12 mb-2 text-center">
            <h2 class="h2 vpg-subtitle">@lang('pgs_public.CONCEPT_HOW_IT_WORKS')</h2>
        </div>
    </div>

    {{--watch --}}
    <div class="row justify-content-center my-5">
        <div class="col-10 text-center order-2
                    col-sm-8
                    col-md-6 text-md-left p-md-5 order-md-1
                    col-lg-5 p-lg-1
                    col-xl-4
                    col-vcenter">
            <h5 class="h5 vpg-desc">@lang('pgs_public.CONCEPT_WATCH_TEXT')</h5>
        </div>
        <div class="col-10 mb-4 order-1
                    col-sm-8 p-sm-5
                    col-md-6 mb-md-0 p-md-5 order-md-2
                    col-lg-4 p-lg-1
                    col-xl-3
                    col-vcenter">
            <img class="d-block mx-auto" style="width: auto; max-width: 200px; height: auto;" src="{{ asset('images/public_pages/concept/watch.png') }}"> 
        </div>
    </div>

    {{-- mobile app --}}
    <div class="row justify-content-center py-5 vstyle-dark">
        <div class="col-10 mb-4
                    col-sm-8 p-sm-5
                    col-md-6 mb-md-0 p-md-5
                    col-lg-4 p-lg-1
                    col-xl-3
                    col-vcenter">
            <img class="d-block mx-auto" style="width: auto; max-height: 300px;" src="{{ asset('images/public_pages/app.png') }}"> 
        </div>
        <div class="col-10 text-center
                    col-sm-8
                    col-md-6 text-md-left p-md-5
                    col-lg-5 p-lg-1
                    col-xl-4
                    col-vcenter">
            <h5 class="h5 vpg-desc vtext-light">@lang('pgs_public.CONCEPT_APP_TEXT')</h5>
        </div>
    </div>

    {{-- web app --}}
    <div class="row justify-content-center my-5">
        <div class="col-10 text-center order-2
                    col-sm-8
                    col-md-6 text-md-left p-md-5 order-md-1
                    col-lg-5 p-lg-1
                    col-xl-4
                    col-vcenter">
            <h5 class="h5 vpg-desc">@lang('pgs_public.CONCEPT_WEB_APP_TEXT')</h5>
        </div>
        <div class="col-10 mb-4 order-1
                    col-sm-8 p-sm-5
                    col-md-6 mb-md-0 p-md-5 order-md-2
                    col-lg-4 p-lg-1
                    col-xl-3
                    col-vcenter">
            <img class="d-block mx-auto" style="width: 100%; height: auto;" src="{{ asset('images/public_pages/concept/web_app.png') }}"> 
        </div>
    </div>

@endsection