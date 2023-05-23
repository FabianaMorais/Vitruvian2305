<div class="row justify-content-center py-5">
    <div class="col-12 text-center mb-5">
        <h1 class="h1 vpg-subtitle">@lang('pgs_public.ABOUT_OUR_SOLUTIONS')</h1>
    </div>

    <div class="col-auto mb-3">
        @component('widgets.vcard_hover')
            @slot('image') {{ asset('images/public_pages/research_main_page.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_RESEARCHERS') @endslot
            @slot('content')
                <p class="h4 mt-2">@lang('pgs_public.FOR_RESEARCHERS')</p>
                <div class="row mt-3">
                    <div class="col-2">
                        <i class="fas fa-check ml-4 ml-lg-2"></i>
                    </div>
                    <div class="col-9 text-left">
                        <span class="h6">@lang('pgs_public.RESEARCHER_DESC_COMP_1')</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 ">
                        <i class="fas fa-check ml-4 ml-lg-2"></i>
                    </div>
                    <div class="col-9 text-left">
                        <span class="h6">@lang('pgs_public.RESEARCHER_DESC_COMP_2')</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 ">
                        <i class="fas fa-check ml-4 ml-lg-2"></i>
                    </div>
                    <div class="col-9 text-left">
                        <span class="h6">@lang('pgs_public.RESEARCHER_DESC_COMP_3')</span>
                    </div>
                </div>
            @endslot
        @endcomponent
    </div>
    <div class="col-auto mb-3">
        @component('widgets.vcard_hover')
            @slot('image') {{ asset('images/public_pages/healthcare.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_DOCTORS') @endslot
            @slot('content')
                <div class="row">
                    <div class="col-12">
                        <p class="h4 mt-2" >@lang('pgs_public.FOR_DOCTORS')</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 text-right">
                        <i class="fas fa-check ml-4 ml-lg-2"></i>
                    </div>
                    <div class="col-9 text-left">
                        <span class="h6">@lang('pgs_public.DOCTOR_DESC_COMP_1')</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 text-right">
                        <i class="fas fa-check ml-4 ml-lg-2"></i>
                    </div>
                    <div class="col-9 text-left">
                        <span class="h6">@lang('pgs_public.DOCTOR_DESC_COMP_2')</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 text-right">
                        <i class="fas fa-check ml-4 ml-lg-2"></i>
                    </div>
                    <div class="col-9 text-left">
                        <span class="h6">@lang('pgs_public.DOCTOR_DESC_COMP_3')</span>
                    </div>
                </div>
            @endslot
        @endcomponent
    </div>
    <div class="col-auto mb-3">
        @component('widgets.vcard_hover')
            @slot('image') {{ asset('images/public_pages/elder_care.png') }} @endslot
            @slot('title') @lang('pgs_public.FOR_ELDERLY_CARE') @endslot
            @slot('content')
                <div class="row">
                    <div class="col-12">
                        <p class="h4 mt-2" >@lang('pgs_public.FOR_ELDERLY_CARE')</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 text-right">
                        <i class="fas fa-check ml-4 ml-lg-2"></i>
                    </div>
                    <div class="col-9 text-left">
                        <span class="h6">@lang('pgs_public.ELDER_CARE_DESC_COMP_1')</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 text-right">
                        <i class="fas fa-check ml-4 ml-lg-2"></i>
                    </div>
                    <div class="col-9 text-left">
                        <span class="h6">@lang('pgs_public.ELDER_CARE_DESC_COMP_2')</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 text-right">
                        <i class="fas fa-check ml-4 ml-lg-2"></i>
                    </div>
                    <div class="col-9 text-left">
                        <span class="h6">@lang('pgs_public.ELDER_CARE_DESC_COMP_3')</span>
                    </div>
                </div>
            @endslot
        @endcomponent
    </div>

</div>