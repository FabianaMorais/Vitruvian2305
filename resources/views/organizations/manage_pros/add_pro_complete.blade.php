@extends('base.page_app')

@section('content')

    <div class="row mt-5">

        <div class="col-12 text-center mt-5 mb-2">
            <i class="vicon-main fas fa-user-check" style="width: 60px; height: 60px; font-size:3em;"></i>
        </div>
        <div class="col-12 text-center">
            <h4 class="h4">@lang('pg_manage_pros.SUCCESS_ADD_TITLE')</h4>
        </div>
        <div class="col-12 text-center mt-2">
            @lang('pg_manage_pros.SUCCESS_ADD_TEXT_A')
        </div>
        <div class="col-12 text-center mt-2">
            @lang('pg_manage_pros.SUCCESS_ADD_TEXT_B')
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-center
                    col-sm-6 text-sm-right">
            <a href="{{ route('org.manage.pros.new') }}" type="button" class="btn vbtn-main">@lang('pg_manage_pros.BTN_ADD_MORE')</a>
        </div>
        <div class="col-12 text-center mt-2
                    col-sm-6 text-sm-left mt-sm-0">
            <a href="{{ route('org.manage.pros') }}" type="button" class="btn vbtn-main">@lang('pg_manage_pros.BTN_RETURN_LIST')</a>
        </div>
    </div>

@endsection