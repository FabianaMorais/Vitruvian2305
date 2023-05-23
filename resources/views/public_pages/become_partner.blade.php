@extends('base.page_public')

@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.BECOME_PARTNER_TTL')</h1>
        </div>
    </div>

    <div class="row justify-content-center" style="min-height:30vh;">
        <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4  col-vcenter order-2 order-md-1 mt-4 mt-md-0">
            <div class="row">
                <div class="col-12 text-center text-md-left ">
                    <h2 class="h2 vpg-desc">@lang('pgs_public.BECOME_PARTNER_INTRO')</h2>
                </div>
                <div class="col-12 text-center text-lg-left mt-2">
                    <a href="{{ route('contact us') }}" class="btn vbtn-main">@lang('pgs_public.CONTACT_US')</a>
                </div>
            </div>
        </div>
        <div class="col-10 col-sm-8 col-md-6 col-lg-4 col-xl-3 col-vcenter order-1 order-md-2">
            <img class="mx-auto" src="{{ asset('images/public_pages/become_partner/contribute.svg') }}" style="width:90%; height:auto;">
        </div>
    </div>

    <div class="row mt-5 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 text-center">
            <h2 class="h2 vpg-desc">@lang('pgs_public.BECOME_PARTNER_SUB_INTRO')</h2>
        </div>
    </div>

    <div class="row mx-0 mb-5 justify-content-center text-center">
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4 mb-lg-0
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/become_partner/investor.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.BECOME_PARTNER_CARD_1') @endslot
            @endcomponent
        </div>
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4 mb-lg-0
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/become_partner/trials.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.BECOME_PARTNER_CARD_2') @endslot
            @endcomponent
        </div>
        <div class="col-12 mb-3
                    col-sm-8
                    col-md-5
                    col-lg-4 mb-lg-0
                    col-xl-3">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/become_partner/remote.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.BECOME_PARTNER_CARD_3') @endslot
            @endcomponent
        </div>
    </div>

@endsection

