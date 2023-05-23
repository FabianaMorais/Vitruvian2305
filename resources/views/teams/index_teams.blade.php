@extends('base.page_app')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="h1">@lang('pgs_manage_teams.TITLE_INDEX')</h1>
        </div>
    </div>

    {{-- Tools --}}
    <div class="row">
        <div class="col-12 text-right">
            <a type="button" class="btn btn-sm vbtn-main" href="{{ route('teams.new') }}">
                <i class="fas fa-file-alt"></i> @lang('pgs_manage_teams.BTN_ADD')
            </a>
        </div>
    </div>
    {{-- Tools --}}


    @if (count($teams) == 0) {{-- if there are no teams to display --}}

        {{-- Empty panel --}}
        <div class="row my-5" style="min-height: 60vh;">

            <div class="col-12 offset-0 col-vcenter mt-3 order-2
                        col-sm-10 offset-sm-1
                        col-md-6 offset-md-0 order-md-1 mt-md-0
                        col-lg-4 offset-lg-2" >

                <div class="row">
                    <div class="col-12">
                        <h3 class="h3">@lang('pgs_manage_teams.EMPTY_MSG_TITLE')</h3>
                        <h6 class="h6 font-weight-light">@lang('pgs_manage_teams.EMPTY_MSG_A')</h6>
                        <h6 class="h6 font-weight-light">@lang('pgs_manage_teams.EMPTY_MSG_B')</h6>
                    </div>

                    <div class="col-12">
                        <a class="btn vbtn-main float-right" href="{{ route('teams.new') }}">@lang('pgs_manage_teams.TEAM_LIST_EMPTY_BTN')</a>
                    </div>
                </div>
            </div>

            <div class="col-12 text-center col-vcenter order-1
                        col-sm-8 offset-sm-2
                        col-md-6 offset-md-0 order-md-2
                        col-lg-4">
                <img class="w-100" src="{{ asset('images/illustrations/manage_teams.png') }}">
            </div>

        </div>
        {{-- Empty panel --}}

    @else {{-- but if there are --}}

        <div class="row mt-3" style="max-height: 70vh; overflow-y: auto;">

            @foreach($teams as $t)
                <div class="col-12 col-md-6 my-3">
                    @component('teams.components.team_card', ['team' => $t])
                    @endcomponent
                </div>
            @endforeach

        </div>

    @endif

@endsection
