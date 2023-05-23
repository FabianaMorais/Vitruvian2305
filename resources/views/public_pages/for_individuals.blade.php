@extends('base.base_canvas')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/components/tools_card.css') }}">
@endsection

@section('page')

<img class="img-bg-fixed" src="{{ asset('images/public_pages/pitch/individuals.png') }}">

<div class="row">
    <div class="col-12 col-vcenter" style="margin-top: 14vh">
        <h1 class="h1 vpg-title">@lang('pgs_public.WIDGET_TARGETS_INDIVIDUALS_TITLE')</h1>
    </div>
</div>

<div class="row justify-content-center mt-5">

    <div class="col-12 offset-0
                col-sm-6 offset-sm-0
                col-md-6 offset-md-0
                col-lg-3 offset-lg-0
                my-4">
        @component('widgets.ico_box')
            @slot('icon') {{ asset('images/public_pages/icons/monitoring.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_CARD_A_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_CARD_A_TEXT') @endslot
        @endcomponent
    </div>
    <div class="col-12 offset-0
                col-sm-6 offset-sm-0
                col-md-6 offset-md-0
                col-lg-3 offset-lg-0
                my-4">
        @component('widgets.ico_box')
            @slot('icon') {{ asset('images/public_pages/icons/prevention.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_CARD_B_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_CARD_B_TEXT') @endslot
        @endcomponent
    </div>
    <div class="col-12 offset-0
                col-sm-6 offset-sm-0
                col-md-6 offset-md-0
                col-lg-3 offset-lg-0
                my-4">
        @component('widgets.ico_box')
            @slot('icon') {{ asset('images/public_pages/icons/sharing.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_CARD_C_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_CARD_C_TEXT') @endslot
        @endcomponent
    </div>
</div>

<div class="row">
    <div class="col-12 px-0">

        @component('public_pages.components.tools_card')
            @slot('card_l_style') vtool-card-C @endslot
            @slot('card_l_img') {{ asset('images/product/vit_watch_round.png') }} @endslot
            @slot('card_l_title') @lang('pgs_public.WIDGET_CONCEPT_WATCH_TITLE') @endslot
            @slot('card_l_text') @lang('pgs_public.WIDGET_CONCEPT_WATCH_DESC') @endslot
            @slot('card_l_btn_text') @lang('pgs_public.EXPLORE') @endslot
            @slot('card_l_btn_link') {{ route('watch') }} @endslot

            @slot('card_r_style') vtool-card-B @endslot
            @slot('card_r_img') {{ asset('images/product/vit_mobile_app.png') }} @endslot
            @slot('card_r_title') @lang('pgs_public.WIDGET_CONCEPT_APP_TITLE') @endslot
            @slot('card_r_text') @lang('pgs_public.WIDGET_CONCEPT_APP_DESC') @endslot
            @slot('card_r_btn_text') @lang('pgs_public.EXPLORE') @endslot
            @slot('card_r_btn_link') {{ route('mobile app') }} @endslot

            @slot('card_desc_title') @lang('pgs_public.FOR_IND_TOOLS_TITLE') @endslot
            @slot('card_desc_text') @lang('pgs_public.FOR_IND_TOOLS_TEXT') @endslot
        @endcomponent

    </div>
</div>


<div class="row mx-0 mx-xl-5 pb-4">
    <div class="col-12 col-vcenter">
        <h2 class="h2 vpg-subtitle">@lang('pgs_public.FEATURES_LIST_TITLE')</h2>
    </div>

    <div class="col-12">
        <h4 class="h4 vpg-desc">@lang('pgs_public.FEATURES_LIST_TEXT')</h4>
    </div>


    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-4
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/seizure.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_FEATURE_A_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_FEATURE_A_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-4
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/emergency_calls.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_FEATURE_B_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_FEATURE_B_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-4
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/health_report.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_FEATURE_C_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_FEATURE_C_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-4
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/appointment.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_FEATURE_D_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_FEATURE_D_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-4
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/medication.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_FEATURE_E_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_FEATURE_E_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-4
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/exam_reminders.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_FEATURE_F_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_FEATURE_F_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-4
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/research.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_IND_FEATURE_G_TITLE') @endslot
            @slot('text') @lang('pgs_public.FOR_IND_FEATURE_G_TEXT') @endslot
        @endcomponent
    </div>

</div>

<div class="row mb-4 mx-1">
    <div class="col-12
                col-sm-10 offset-sm-1
                col-md-8 offset-md-2
                col-lg-8 offset-lg-2
                col-xl-6 offset-xl-3">

        <div class="alert alert-vdark notice p-4" role="alert">
            <h4 class="alert-heading">@lang('pgs_public.DISCLAIMER_TITLE')</h4>
            <hr>
            <p>@lang('pgs_public.DISCLAIMER_TEXT_IND')</p>
        </div>

    </div>
</div>

<div class="row mx-0 mx-xl-5">

    <div class="col-12 col-vcenter">
        <h2 class="h2 vpg-subtitle">@lang('pgs_public.LEAVE_MSG_TITLE')</h2>
    </div>

    <div class="col-12">
            <h4 class="h4 vpg-desc">@lang('pgs_public.LEAVE_MSG_TEXT')</h4>
        </div>
    </div>

    <div class="col-12
                col-sm-10 offset-sm-1
                col-md-8 offset-md-2
                col-lg-8 offset-lg-2
                col-xl-6 offset-xl-3
                pb-5">

        <div class="vcard-canvas w-100">
            @include('widgets.contact_form')
        </div>

    </div>
</div>

@endsection