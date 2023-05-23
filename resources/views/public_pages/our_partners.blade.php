@extends('base.page_public')

@section('content')
    <div class="row mb-2">
        <div class="col-12 text-center mb-4">
            <h1 class="h1 vpg-title">@lang('pgs_public.PARTNERS_TTL')</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12
                    col-sm-8
                    col-md-6
                    col-lg-4
                    col-xl-3
                    mb-4">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/our_partners/skilled_professionals.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.OUR_PARTNERS_INTRO_CARD_1') @endslot
            @endcomponent
        </div>

        <div class="col-12
                    col-sm-8
                    col-md-6
                    col-lg-4
                    col-xl-3
                    mb-4">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/our_partners/scientific_validation.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.OUR_PARTNERS_INTRO_CARD_2') @endslot
            @endcomponent
        </div>
        <div class="col-12
                    col-sm-8
                    col-md-6
                    col-lg-4
                    col-xl-3
                    mb-4">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/our_partners/celebrate.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.OUR_PARTNERS_INTRO_CARD_3') @endslot
            @endcomponent
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 col-sm-10 offset-sm-1 text-center">
            <h2 class="h2 vpg-subtitle">
                @lang('pgs_public.PARTNERS_ACADEMIC_TTL')
            </h2>
        </div>
        <div class="col-12 col-sm-10 offset-sm-1 text-center">
            <h6 class="h6">
                @lang('pgs_public.PARTNERS_ACADEMIC_TEXT')
            </h6>
        </div>
        <div class="col-12">
            <div class="row justify-content-center">
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/neuro_tech.png') }} @endslot
                        @slot('title') NeuroTech Foundation @endslot
                        @slot('text') <small>Product development and performance of clinical studies</small> @endslot
                        @slot('website_link') http://neurotech.healthcare/ @endslot
                    @endcomponent
                </div>
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/chuv.png') }} @endslot
                        @slot('title') Centre Hospitalier Universitaire Vaudois @endslot
                        @slot('text') <small>Product development and performance of clinical studies</small> @endslot
                        @slot('website_link') https://www.chuv.ch/fr/neurologie/nlg-home/ @endslot
                    @endcomponent
                </div>
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/klinik_lengg.png') }} @endslot
                        @slot('title') Klinik Lengg @endslot
                        @slot('text') <small>Product development and performance of clinical studies</small> @endslot
                        @slot('website_link') https://www.kliniklengg.ch/ @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 col-sm-10 offset-sm-1 text-center">
            <h2 class="h2 vpg-subtitle">
                @lang('pgs_public.PARTNERS_FINANCIAL_TTL')
            </h2>
        </div>
        <div class="col-12 col-sm-10 offset-sm-1 text-center">
            <h6 class="h6 ">
                @lang('pgs_public.PARTNERS_FINANCIAL_TEXT')
            </h6>
        </div>
        <div class="col-12">
            <div class="row justify-content-center">
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/confederation_suisse.png') }} @endslot
                        @slot('title') Schweizerische Eidgenossenschaft @endslot
                        @slot('text') <small><b>Innossuisse - Agence suisse pour l'encouragement de l'innovation</b></small> @endslot
                        @slot('website_link') https://www.innosuisse.ch/inno/en/home.html @endslot
                    @endcomponent
                </div>
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/schweizer_berghilfe.png') }} @endslot
                        @slot('title') Schweizer Berghilfe @endslot
                        @slot('website_link') https://www.aidemontagne.ch/ @endslot
                    @endcomponent
                </div>
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/ne.png') }} @endslot
                        @slot('title') République et Canton de Neuchâtel - Service de l'économie @endslot
                        @slot('website_link') https://neuchateleconomie.ch/ @endslot
                    @endcomponent
                </div>
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/gilomen.png') }} @endslot
                        @slot('title') Gilomen Fiscalité and Conseils S.A. @endslot
                        @slot('website_link') https://www.fiduciairegilomen.ch/bienvenue @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 col-sm-10 offset-sm-1 text-center">
            <h2 class="h2 vpg-subtitle">
                @lang('pgs_public.PARTNERS_TECH_TTL')
            </h2>
        </div>
        <div class="col-12 col-sm-10 offset-sm-1 text-center">
            <h6 class="h6 ">
                @lang('pgs_public.PARTNERS_TECH_TEXT')
            </h6>
        </div>
        <div class="col-12">
            <div class="row justify-content-center">
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/analog_devices.png') }} @endslot
                        @slot('title') Analog Devices @endslot
                        @slot('website_link') https://www.analog.com/en/index.html @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>

    {{--social partners --}}
    <div class="row my-5">
        <div class="col-12 col-sm-10 offset-sm-1 text-center">
            <h2 class="h2 vpg-subtitle">
                @lang('pgs_public.EPILEPSY_ADVISORS_TTL')
            </h2>
        </div>
        <div class="col-12 col-sm-10 offset-sm-1 text-center">
            <h6 class="h6">
                @lang('pgs_public.EPILEPSY_ADVISORS_TEXT')
            </h6>
        </div>
        <div class="col-12">
            <div class="row justify-content-center">
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/epi_suisse_logo.png') }} @endslot
                        @slot('title') EPI Suisse @endslot
                        @slot('website_link') https://epi-suisse.ch/ @endslot
                    @endcomponent
                </div>
                <div class="col-auto my-3">
                    @component('public_pages.components.partner_card')
                        @slot('img_src') {{ asset('images/partners/LSCE_logo.png') }} @endslot
                        @slot('title') Swiss League Against Epilepsy @endslot
                        @slot('website_link') https://www.epi.ch/publikationen/filme/kurzfilm-erste-hilfe/ @endslot
                    @endcomponent
                </div>
            </div>
        </div>
    </div>

@endsection