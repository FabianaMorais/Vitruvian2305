@extends('base.page_public')

@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.DATA_RESEARCH_TTL')</h1>
        </div>
    </div>

    <div class="row mt-5 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 text-center">
            <h2 class="h2 vpg-desc">@lang('pgs_public.DATA_AND_RESEARCH_INTRO')</h2>
        </div>
    </div>

    {{--first set of cards--}}
    <div class="row mx-0 mx-lg-3 justify-content-center ">
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/data_and_research/telemedicine.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.DATA_AND_RESEARCH_CARD_1') @endslot
            @endcomponent
        </div>
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/data_and_research/data_portrait.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.DATA_AND_RESEARCH_CARD_2') @endslot
            @endcomponent
        </div>
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/data_and_research/body_signals.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.DATA_AND_RESEARCH_CARD_3') @endslot
            @endcomponent
        </div>
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/data_and_research/mortality.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.DATA_AND_RESEARCH_CARD_4') @endslot
            @endcomponent
        </div>
    </div>

    {{--subtitle --}}
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h2 class="h2 vpg-desc">@lang('pgs_public.DATA_AND_RESEARCH_SECONDARY_TITLE')</h2>
        </div>
    </div>
    
    {{--second set of cards--}}
    <div class="row mx-0 mb-5 justify-content-center text-center">
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/data_and_research/certification.svg') }} @endslot
                @slot('list_content') 
                    <li class="list-group-item h6">@lang('pgs_public.DATA_AND_RESEARCH_CARD_5_B1')</li>
                    <li class="list-group-item h6">@lang('pgs_public.DATA_AND_RESEARCH_CARD_5_B2')</li>
                @endslot
            @endcomponent
        </div>
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/data_and_research/dataset_location.svg') }} @endslot
                @slot('list_content') 
                    <li class="list-group-item h6">@lang('pgs_public.DATA_AND_RESEARCH_CARD_6_B1')</li>
                    <li class="list-group-item h6"><a href="{{ route('microsoft azure cloud') }}" class="btn vbtn-main">@lang('pgs_public.MORE_INFO_BUTTON')</a></li>

                @endslot
            @endcomponent
        </div>
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/data_and_research/anonymous.svg') }} @endslot
                @slot('list_content') 
                    <li class="list-group-item h6">@lang('pgs_public.DATA_AND_RESEARCH_CARD_7_B1')</li>
                    <li class="list-group-item h6">@lang('pgs_public.DATA_AND_RESEARCH_CARD_7_B2')</li>
                    <li class="list-group-item h6">@lang('pgs_public.DATA_AND_RESEARCH_CARD_7_B3')</li>
                @endslot
            @endcomponent
        </div>
    </div>

@endsection