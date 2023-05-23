@extends('base.page_app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="h1">@lang('pg_profile.DELETED_TITLE')</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center mt-5">
            <img style="width: 120px; height: 120px;" src="{{ asset('images/core/logo-vert.svg') }}">
            <h6 class="h6 mt-3">@lang('pg_profile.DELETED_TEXT_A')</h6>
            <h6 class="h6 mt-3">@lang('pg_profile.DELETED_TEXT_B')</h6>
            <h6 class="h6 mt-5">@lang('pg_profile.DELETED_TEXT_C')</h6>
            <a class="btn vbtn-main mt-3" type="button" href="{{ route('welcome') }}">@lang('pg_profile.BTN_DELETED')</a>
        </div>
    </div>

@endsection