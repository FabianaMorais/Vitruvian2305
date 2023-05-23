{{-- Characterization --}}
<div class="row align-items-end">
    <div class="col">
        <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('record_team.TITLE_CHARACTERIZATION')</h6>
    </div>

    @isset($editable) {{-- Appears only if user has edit permissions --}}
    <div class="col-auto">
        <button class="btn btn-sm vbtn-main" onclick="openSettings()"><i class="fas fa-cog"></i> @lang('record_team.EDIT_CHARACTERIZATION')</button>
    </div>
    @endif

    <div class="col-12">
        <hr class="mt-1">
    </div>
</div>

<div class="row">
    {{-- Team Name --}}
    <div class="col-12
                col-md-10 offset-md-1">
        <h6 class="h6 font-weight-light">@lang('record_team.NAME')</h6>
    </div>

    <div class="col-12
                col-md-10 offset-md-1">
        <h6 id="txt_team_name" class="h6">{{ $team->name }}</h6>
    </div>
    {{-- Team Name --}}

    {{-- Description --}}
    <div class="col-12 mt-3
                col-md-10 offset-md-1">
        <h6 class="h6 font-weight-light">@lang('record_team.DESCRIPTION')</h6>
    </div>

    <div class="col-12
                col-md-10 offset-md-1">
        <h6 id="txt_team_description" class="h6">{!! nl2br($team->description) !!}</h6>
    </div>
    {{-- Description --}}

</div>
{{-- Characterization --}}

@isset($editable) {{-- Is drawn only if user has edit permissions --}}

    {{-- Team Settings Modal--}}
    <div id="md_manage_settings" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="h5 modal-title">@lang('record_team.MD_SETTINGS_TITLE')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @component('widgets.panel_error')
                        @slot('id') panel_manage_settings_error @endslot
                    @endcomponent

                    @component('widgets.panel_loading')
                        @slot('id') panel_manage_settings_loading @endslot
                    @endcomponent

                    <div id="panel_manage_settings_list" class="row">
                        <div class="col-12">
                            <h6 class="h6 font-weight-light">@lang('record_team.NAME')</h6>
                        </div>
                        <div class="col-12">
                            <input id="in_name" class="form-control form-control-lg {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('record_team.NAME_PH')" value="{{ $team->name }}">
                            <div id='in_name_fb' class="invalid-feedback">@lang('validation.VAL_MIN_5')</div>
                        </div>

                        <div class="col-12 mt-3">
                            <h6 class="h6 font-weight-light">@lang('record_team.DESCRIPTION')</h6>
                        </div>
                        <div class="col-12">
                            <textarea id="in_description" type="text" class="form-control form-control-sm {{ $errors->has('description') ? ' is-invalid' : '' }}"  rows="5" maxlength="800" placeholder="@lang('record_team.DESCRIPTION_PH')">{{ $team->description }}</textarea>
                            <div id='in_description_fb' class="invalid-feedback">@lang('validation.VAL_MIN_5')</div>
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col col-vcenter">
                                            <h6 class="h6 font-weight-light mb-0">@lang('record_team.TXT_DELETE')</h6>
                                        </div>
                                        <div class="col-auto col-vcenter">
                                            <button type="button" onclick="clickDelete()" class="btn btn-sm vbtn-negative">@lang('record_team.BTN_DELETE')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm vbtn-support" data-dismiss="modal">{{ ucfirst(trans('generic.CANCEL')) }}</button>
                    <button id="btn_manage_settings_save" onclick="submitSettings()" type="button" class="btn btn-sm vbtn-main">@lang('record_team.BTN_SAVE')</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Team Settings Modal--}}


    {{-- Team Delete Modal--}}
    <div id="md_manage_confirm_delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header vstyle-negative">
                    <h5 class="h5 modal-title">@lang('record_team.CONFIRM_DELETE_TITLE')</h5>
                </div>
                <div class="modal-body">
                    @lang('record_team.CONFIRM_DELETE_TXT')
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('teams.update.delete', $team->key) }}">
                        @csrf
                        <button type="submit" class="btn vbtn-negative">{{ucfirst(trans('generic.DEL'))}}</button>
                    </form>
                    <button type="button" class="btn vbtn-support" data-dismiss="modal">{{ucfirst(trans('generic.CANCEL'))}}</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Team Delete Modal--}}

@endif