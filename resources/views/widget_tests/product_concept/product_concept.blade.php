@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/unused/concept_squares.css') }}">
@endsection


<div class="row justify-content-center my-5 py-5 px-lg-5 vstyle-dark">

    <div class="col-12 text-center my-5">
        <h3 class="h3">@lang('pgs_public.WIDGET_CONCEPT_TITLE')</h3>
        <h4 class="h4">@lang('pgs_public.WIDGET_CONCEPT_DESC')</h4>
    </div>

    <div class="col
                col-md-6
                col-xl-3">
        @component('widgets.product_concept.concept_card')
            @slot('image') {{ asset('images/product/vit_watch_round.png') }} @endslot
            @slot('title') @lang('pgs_public.WIDGET_CONCEPT_WATCH_TITLE') @endslot
            @slot('text') @lang('pgs_public.WIDGET_CONCEPT_WATCH_DESC') @endslot
            @slot('btn_text') @lang('pgs_public.WIDGET_CONCEPT_LINK_MORE') @endslot
            @slot('btn_link') # @endslot
        @endcomponent
    </div>

    <div class="col
                col-md-6
                col-xl-3">
        @component('widgets.product_concept.concept_card')
            @slot('image') {{ asset('images/product/vit_mobile_app.png') }} @endslot
            @slot('title') @lang('pgs_public.WIDGET_CONCEPT_APP_TITLE') @endslot
            @slot('text') @lang('pgs_public.WIDGET_CONCEPT_APP_DESC') @endslot
            @slot('btn_text') @lang('pgs_public.WIDGET_CONCEPT_LINK_MORE') @endslot
            @slot('btn_link') # @endslot
        @endcomponent
    </div>

    <div class="col
                col-md-6
                col-xl-3">
        @component('widgets.product_concept.concept_card')
            @slot('image') {{ asset('images/product/vit_web_app.png') }} @endslot
            @slot('shadow') true @endslot
            @slot('title') @lang('pgs_public.WIDGET_CONCEPT_WEB_TITLE') @endslot
            @slot('text') @lang('pgs_public.WIDGET_CONCEPT_WEB_DESC') @endslot
            @slot('btn_text') @lang('pgs_public.WIDGET_CONCEPT_LINK_MORE') @endslot
            @slot('btn_link') # @endslot
        @endcomponent
    </div>

    <div class="col
                col-md-6
                col-xl-3">
        @component('widgets.product_concept.concept_card')
            @slot('image') {{ asset('images/product/vit_web_app.png') }} @endslot
            @slot('shadow') true @endslot
            @slot('title') @lang('pgs_public.WIDGET_CONCEPT_API_TITLE') @endslot
            @slot('text') @lang('pgs_public.WIDGET_CONCEPT_API_DESC') @endslot
            @slot('btn_text') @lang('pgs_public.WIDGET_CONCEPT_LINK_MORE') @endslot
            @slot('btn_link') # @endslot
        @endcomponent
    </div>

</div>