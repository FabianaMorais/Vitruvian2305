<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-auto">
                <h2><i class="vicon-main fas fa-user-slash"></i></h2>
            </div>
            <div class="col">
                <h6 class="h6 mb-1 text-break">@lang('pg_profile.PANEL_DEL_TITLE')</h6>
                <h6 class="h6 font-weight-light text-break">@lang('pg_profile.PANEL_DEL_TEXT')</h6>
            </div>
        </div>
    </div>

    <div class="card-body p-2">
        <div class="row">

            <div class="col-12">
                <button class="btn btn-link btn-block text-center text-wrap" type="button" data-toggle="collapse" data-target="#collapse_delete_account" aria-expanded="false" aria-controls="collapse_delete_account">
                    @lang('pg_profile.PANEL_DEL_BTN')
                </button>
            </div>

            <div class="col-12">
                <div id="collapse_delete_account" class="collapse">
                    <div class="row">

                        <div class="col-12">
                            <h6 class="h6">@lang('pg_profile.DEL_ACCOUNT_TXT')</h6>
                        </div>

                        <div class="col-12 text-center">
                            <button class="btn btn-sm vbtn-negative" type="button" data-toggle="modal" data-target="#md_del_account">
                                @lang('pg_profile.DEL_ACCOUNT_BTN')
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Delete account confirmation modal --}}
<div class="modal fade" id="md_del_account" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal modal-dialog-centered" role="document">
            <div class="modal-content border-0">

                <form action="{{ route('profile.delete') }}" method="POST">
                @csrf
                    <div class="modal-header vstyle-negative">
                        <h5 class="h5 modal-title">@lang('pg_profile.MD_DEL_TITLE')</h5>
                    </div>
                    <div class="modal-body">
                        <h6 class="h6">@lang('pg_profile.MD_DEL_TXT_A')</h6>
                        <h6 class="h6 font-weight-bold"><u>@lang('pg_profile.MD_DEL_TXT_B')</u></h6>
                        <h6 class="h6 mt-4">@lang('pg_profile.MD_DEL_TXT_C')</h6>

                        <li class="ml-md-4">@lang('pg_profile.MD_DEL_TXT_LI_A')</li>
                        <li class="ml-md-4">@lang('pg_profile.MD_DEL_TXT_LI_B')</li>

                        <h6 class="h6 mt-4">@lang('pg_profile.MD_DEL_CB_TXT')</h6>

                        <div class="custom-control custom-checkbox ml-md-4">
                            <input id="cb_keep_data" name="cb_keep_data" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="cb_keep_data">@lang('pg_profile.MD_DEL_CB')</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn vbtn-negative">{{ucfirst(trans('generic.DEL'))}}</button>
                        <button type="button" class="btn vbtn-support" data-dismiss="modal">{{ucfirst(trans('generic.CANCEL'))}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
{{-- Delete account confirmation modal --}}