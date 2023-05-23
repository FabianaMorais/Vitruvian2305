<div class="row justify-content-center frozen-panel py-5"
    style="background-image: url( {{ asset('images/public_pages/bg_why.jpg') }} );">

    <div class="col-12 text-center my-3">
        <h2 class="h2 vpg-subtitle vtext-light">@lang('pgs_public.WHY_VITRUVIAN_SHIELD')</h2>
    </div>

    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-3
                my-4">
        @component('widgets.ico_box')
            @slot('icon') {{ asset('images/public_pages/icons/monitoring.png') }} @endslot
            @slot('title') @lang('pgs_public.WHY_VS_CARD_1_TTL') @endslot
            @slot('text') @lang('pgs_public.WHY_VS_CARD_1_DESC') @endslot
        @endcomponent
    </div>
    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-3
                my-4">
        @component('widgets.ico_box')
            @slot('icon') {{ asset('images/public_pages/icons/diagnosis.png') }} @endslot
            @slot('title') @lang('pgs_public.WHY_VS_CARD_2_TTL') @endslot
            @slot('text') @lang('pgs_public.WHY_VS_CARD_2_DESC') @endslot
        @endcomponent
    </div>
    <div class="col-12
                col-sm-6
                col-md-6
                col-lg-3
                my-4">
        @component('widgets.ico_box')
            @slot('icon') {{ asset('images/public_pages/icons/research_full.png') }} @endslot
            @slot('title') @lang('pgs_public.WHY_VS_CARD_3_TTL') @endslot
            @slot('text') @lang('pgs_public.WHY_VS_CARD_3_DESC') @endslot
        @endcomponent
    </div>
</div>