@extends('base.page_app')

@section('content')


    <div class="row">
        <div class="col-12">
            <h1 class="h1">@lang('pgs_manage_teams.TITLE_VIEW')</h1>
        </div>
    </div>

    @component('teams.components.team_record', ['team' => $team])
        @if( isset($is_editor) && $is_editor === true)
            @slot('editable') {{ true }} @endslot
        @endif
    @endcomponent

@endsection
