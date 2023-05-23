@extends('new_users.base_home_new_users')

@section('info')

    @component('widgets.illustration_panel_h')
        @slot('title') @lang('pg_home_new_users.WELCOME') @endslot
        @slot('desc_1') @lang('pg_home_new_users.THANK_YOU_ORGS') @endslot
        @slot('desc_2') @lang('pg_home_new_users.MSG_ORGS') @endslot
        @slot('illustration') welcome.png @endslot
    @endcomponent

@endsection