@extends('base.page_public')

@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.THE_PROBLEM_TTL')</h1>
        </div>
    </div>
    <div class="row justify-content-center pb-4 px-0 px-md-5">
        <div class="col-10 mb-4
                    col-sm-8
                    col-md-6
                    col-xl-4">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/the_problem/lonely.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.THE_PROBLEM_CARD_1_TEXT') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4
                    col-sm-8
                    col-md-6
                    col-xl-4">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/the_problem/swiss_patients.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.THE_PROBLEM_CARD_2_TEXT') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4
                    col-sm-8
                    col-md-6
                    col-xl-4">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/the_problem/child.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.THE_PROBLEM_CARD_3_TEXT') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4
                    col-sm-8
                    col-md-6
                    col-xl-4">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/the_problem/hard_diagnosis.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.THE_PROBLEM_CARD_4_TEXT') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4
                    col-sm-8
                    col-md-6
                    col-xl-4">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/the_problem/relapse.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.THE_PROBLEM_CARD_5_TEXT') @endslot
            @endcomponent
        </div>
        <div class="col-10 mb-4
                    col-sm-8
                    col-md-6
                    col-xl-4">
            @component('widgets.vcard')
                @slot('image') {{ asset('images/public_pages/the_problem/danger_warning.svg') }} @endslot
                @slot('card_text') @lang('pgs_public.THE_PROBLEM_CARD_6_TEXT') @endslot
            @endcomponent
        </div>
    </div>
@endsection