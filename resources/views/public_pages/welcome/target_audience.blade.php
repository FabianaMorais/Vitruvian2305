@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/components/target_audience_cards.css') }}">
@endsection

<div class="row justify-content-center px-lg-5">

    <div class="col-auto">
            @component('public_pages.welcome.audience_card')
                @slot('image') {{ asset('images/public_pages/pitch/card_individuals.jpg') }} @endslot
                @slot('title') @lang('pgs_public.WIDGET_TARGETS_INDIVIDUALS_TITLE') @endslot
                @slot('text') @lang('pgs_public.WIDGET_TARGETS_INDIVIDUALS_DESC') @endslot
                @slot('btn_text') @lang('pgs_public.WIDGET_CONCEPT_LINK_MORE') @endslot
                @slot('btn_link') {{ route('pitch.patients') }} @endslot
            @endcomponent
    </div>

    <div class="col-auto">
        @component('public_pages.welcome.audience_card')
            @slot('image') {{ asset('images/public_pages/pitch/card_professionals.jpg') }} @endslot
            @slot('title') @lang('pgs_public.WIDGET_TARGETS_PROS_TITLE') @endslot
            @slot('text') @lang('pgs_public.WIDGET_TARGETS_PROS_DESC') @endslot
            @slot('btn_text') @lang('pgs_public.WIDGET_CONCEPT_LINK_MORE') @endslot
            @slot('btn_link') {{ route('pitch.pros') }} @endslot
        @endcomponent
    </div>

    <div class="col-auto">
        @component('public_pages.welcome.audience_card')
            @slot('image') {{ asset('images/public_pages/pitch/card_researchers.jpg') }} @endslot
            @slot('title') @lang('pgs_public.WIDGET_TARGETS_RESEARCHERS_TITLE') @endslot
            @slot('text') @lang('pgs_public.WIDGET_TARGETS_RESEARCHERS_DESC') @endslot
            @slot('btn_text') @lang('pgs_public.WIDGET_CONCEPT_LINK_MORE') @endslot
            @slot('btn_link') {{ route('pitch.researchers') }} @endslot
        @endcomponent
    </div>

</div>