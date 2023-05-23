<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-auto">
                <h2><i class="vicon-main fas fa-lock"></i></h2>
            </div>
            <div class="col">
                <h6 class="h6 mb-1 text-break">@lang('pg_profile.PANEL_PW_TITLE')</h6>
                <h6 class="h6 font-weight-light text-break">@lang('pg_profile.PANEL_PW_TEXT')</h6>
            </div>
        </div>
    </div>

    <div class="card-body p-2">
        <div id="panel_change_pw" class="row">

            <div class="col-12">
                <button class="btn btn-link btn-block text-center text-wrap" type="button" onclick="openChangePwPanel()">
                    @lang('pg_profile.PANEL_PW_BTN')
                </button>
            </div>

            <div class="col-12">
                <div id="collapse_change_pw" class="collapse">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="h6" for="in_old_pw">@lang('pg_profile.PW_TITLE')</label>
                                <input id="in_old_pw" type="password" maxlength="80" class="form-control" placeholder="@lang('pg_profile.PW_PH')">

                                <div>
                                    <div id="in_old_pw_fb" class="invalid-feedback">
                                        @lang('validation.VAL_WRONG')
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="h6" for="in_new_pw">@lang('pg_profile.PW_NEW_TITLE')</label>
                                <input id="in_new_pw" type="password" maxlength="80" class="form-control" placeholder="@lang('pg_profile.PW_NEW_PH')">

                                <div>
                                    <div id="in_new_pw_fb_size" class="invalid-feedback">
                                        @lang('validation.VAL_MIN_8')
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="h6" for="in_new_pw_confirmation">@lang('pg_profile.PW_CONFIRMATION_TITLE')</label>
                                <input id="in_new_pw_confirmation" type="password" maxlength="80" class="form-control" placeholder="@lang('pg_profile.PW_CONFIRMATION_PH')">

                                <div>
                                    <div id="in_new_pw_fb_match" class="invalid-feedback">
                                        @lang('validation.VAL_PASSWORD_CONFIRMATION')
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button class="btn btn-sm vbtn-main" type="button" onclick="changePassword()">
                                @lang('pg_profile.CHANGE_PW_BTN')
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @component('widgets.panel_loading')
            @slot('id') panel_change_pw_loading @endslot
        @endcomponent

        @component('widgets.panel_error')
            @slot('id') panel_change_pw_error @endslot
        @endcomponent

        <div id="panel_change_pw_success" class="row" style="display: none;">
            <div class="col-12 text-center">
                <label class="h6" for="in_old_pw">@lang('pg_profile.CHANGE_PW_SUCCESS_TEXT')</label>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-sm vbtn-main" type="button" onclick="resetChangePwPanel()">
                    {{ ucfirst( trans('generic.CONTINUE') )}}
                </button>
            </div>
        </div>
    </div>

</div>

@section('js')
    @parent
    <script type="text/javascript">
        changePwUrl = {!! json_encode(route('profile.change_pw'), JSON_HEX_TAG) !!};
    </script>
    <script type="text/javascript" src="{{ asset('js/change_password.js') }}"></script>
    {{-- NOTE: Requires js form_validation.js to be in the page --}}
@endsection