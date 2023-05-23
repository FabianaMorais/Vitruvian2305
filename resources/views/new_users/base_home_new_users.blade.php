@extends('base.page_app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pg_home_new_users.PAGE_TITLE')</h1>
        </div>

        <div class="col-12 text-center my-3">
            <img style="width: auto; height: auto" src="{{ asset('images/core/logo-vert.svg') }}">
        </div>

    </div>

    @hasSection('info')
        @yield('info')
    @endif

@endsection