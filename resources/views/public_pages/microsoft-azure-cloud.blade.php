@extends('base.page_public')

@section('content')

<div class="row mx-0 mx-xl-5 pb-4">
    <div class="col-12 col-vcenter">
        <h2 class="h2 vpg-subtitle">@lang('pgs_public.AZURE_TITLE')</h2>
    </div>

    <div class="col-12">
        <h4 class="h4 vpg-desc">@lang('pgs_public.AZURE_LIST_TEXT')</h4>
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-6
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/verified.png') }} @endslot
            @slot('title') @lang('pgs_public.AZURE_REASON_1_TITLE') @endslot
            @slot('text') @lang('pgs_public.AZURE_REASON_1_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6s
                col-lg-6
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/resize.png') }} @endslot
            @slot('title') @lang('pgs_public.AZURE_REASON_2_TITLE') @endslot
            @slot('text') @lang('pgs_public.AZURE_REASON_2_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-6
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/innovation.png') }} @endslot
            @slot('title') @lang('pgs_public.AZURE_REASON_3_TITLE') @endslot
            @slot('text') @lang('pgs_public.AZURE_REASON_3_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-6
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/charts.png') }} @endslot
            @slot('title') @lang('pgs_public.AZURE_REASON_4_TITLE') @endslot
            @slot('text') @lang('pgs_public.AZURE_REASON_4_TEXT') @endslot
        @endcomponent
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-6
                mb-3">
        @component('widgets.icon_card_h')
            @slot('icon') {{ asset('images/public_pages/icons/internet.png') }} @endslot
            @slot('title') @lang('pgs_public.AZURE_REASON_5_TITLE') @endslot
            @slot('text') @lang('pgs_public.AZURE_REASON_5_TEXT') @endslot
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
            <p>@lang('pgs_public.AZURE_WORK_IN_PROGRESS')</p>
            <div class="w-100 text-center">
                <a href="{{ route('become partner') }}" class="btn vbtn-pop vbtn-large">@lang('pgs_public.BECOME_PARTENER_BUTTON')</a>
            </div>
        </div>

    </div>
</div>


@endsection