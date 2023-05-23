@extends('base.page_public_dark')

@section('content')
    <div class="row" style="min-height: 88vh;">

        <div class="col-12 text-center mt-5">
            <h1 class="h1 vpg-title vtext-light">@lang('pgs_public.WATCH_TTL')</h1>
        </div>

        <div class="col-12">
            <div class="row">

                <div class="col-12 order-2
                            col-sm-10 offset-sm-1
                            col-md-8 offset-md-2
                            col-lg-5 offset-lg-1 order-lg-1
                            col-xl-5 offset-xl-1
                            col-vcenter">
                    <h3 class="h3 vpg-desc vtext-light">@lang('pgs_public.SMARTWATCH_MAIN_SUBTTL')</h3> 
                </div>

                <div class="col-12 order-1
                            col-sm-10 offset-sm-1
                            col-md-8 offset-md-2
                            col-lg-5 offset-lg-0 order-lg-2
                            col-xl-5
                            col-vcenter">

                    {{-- Carousel --}}
                    <div id="carouselWatch" class="carousel slide col-vcenter" data-ride="carousel" style="height: 460px;">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselWatch" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselWatch" data-slide-to="1"></li>
                            <li data-target="#carouselWatch" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner h-75">
                            <div class="carousel-item h-100 active">
                                <img class="d-block mx-auto" style="max-width: 100%; max-height: 100%;" src="{{ asset('images/public_pages/watch/main_watch_page_montage.png') }}"> 
                            </div>
                            <div class="carousel-item h-100">
                                <img class="d-block mx-auto" style="max-width: 100%; max-height: 100%;" src="{{ asset('images/public_pages/watch/watch_back.png') }}"> 
                            </div>
                            <div class="carousel-item h-100">
                                <img class="d-block mx-auto" style="max-width: 100%; max-height: 100%;" src="{{ asset('images/public_pages/watch/watch_front.png') }}"> 
                            </div>
                        </div>
                    </div>
                    {{-- Carousel --}}

                </div>

            </div>
        </div>

    </div>


    <div class="row py-5 justify-content-center vstyle-light">
        <div class="col-12 text-center order-2
                    col-sm-10
                    col-md-8
                    col-lg-4 text-lg-left order-lg-1
                    col-vcenter">
            <h2 class="h2 vpg-subtitle">@lang('pgs_public.SMARTWATCH_MOBILE_SENSOR_TOGGLE_TTL')</h2>
            <h4 class="h4 vpg-desc">@lang('pgs_public.SMARTWATCH_MOBILE_SENSOR_TOGGLE_TEXT')</h4>
        </div>
        <div class="col-12 order-1
                    col-sm-10
                    col-md-8
                    col-lg-3 order-lg-2">
            <img class="d-block mx-auto" style="width: 80%; height: auto;" src="{{ asset('images/public_pages/watch/watch_with_phone.png') }}"> 
        </div>
    </div>

    <div class="row pb-4 vstyle-light">
        <div class="col-12 text-center">
            <h2 class="h2 vpg-subtitle">@lang('pgs_public.SMARTWATCH_SUBTITLE')</h2>
        </div>
    </div>

    <div class="row justify-content-center pb-4 px-0 px-md-5 vstyle-light">
        <div class="col-10 mb-4 px-3
                    col-sm-8
                    col-md-6
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/watch/heart.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.SMARTWATCH_CARD_TEXT_1') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4 px-3
                    col-sm-8
                    col-md-6
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/watch/stress.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.SMARTWATCH_CARD_TEXT_2') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4 px-3
                    col-sm-8
                    col-md-6
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/watch/bioelectrical.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.SMARTWATCH_CARD_TEXT_3') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4 px-3
                    col-sm-8
                    col-md-6
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/watch/motion.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.SMARTWATCH_CARD_TEXT_4') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4 px-3
                    col-sm-8
                    col-md-6
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/watch/sleep.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.SMARTWATCH_CARD_TEXT_5') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4 px-3
                    col-sm-8
                    col-md-6
                    col-xl-4 px-xl-5">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/watch/temperature.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.SMARTWATCH_CARD_TEXT_6') @endslot
            @endcomponent
        </div>
    </div>

@endsection