@extends('base.page_public')

@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.CERTIFICATIONS_TTL')</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-2 text-center text-sm-justify">
            <h2 class="h2 vpg-desc">@lang('pgs_public.CERTIFICATIONS_TEXT_1')</h2>
        </div>
    </div>
    <div class="row justify-content-center my-3">
        <div class="col-auto mb-2">
            @component('public_pages.components.certification_card')
                @slot('img_src') {{ asset('images/certifications/iso_13485.png') }} @endslot
                @slot('title') ISO 13485 @endslot
            @endcomponent
        </div>
        <div class="col-auto mb-2">
            @component('public_pages.components.certification_card')
                @slot('img_src') {{ asset('images/certifications/ce.png') }} @endslot
                @slot('title') Medical Devices Class IIb @endslot
            @endcomponent
            </div>
        </div>
    </div>
@endsection