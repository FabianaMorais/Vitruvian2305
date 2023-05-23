@extends('base.page_app')

@section('content')

    <div class="row mt-5">

        <div class="col-12 text-center mt-5 mb-2">
            <i class="vicon-main fas fa-eraser" style="width: 60px; height: 60px; font-size:3em;"></i>
        </div>
        <div class="col-12 text-center">
            <h4 class="h4">@lang('pgs_manage_teams.SUCCESS_DELETE_TITLE')</h4>
        </div>
        <div class="col-12 text-center mt-2">
            @lang('pgs_manage_teams.SUCCESS_DELETE_TEXT')
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-center mt-2">
            <a href="{{ route('teams.index') }}" type="button" class="btn vbtn-main">@lang('pgs_manage_teams.BTN_RETURN_LIST')</a>
        </div>
    </div>

@endsection