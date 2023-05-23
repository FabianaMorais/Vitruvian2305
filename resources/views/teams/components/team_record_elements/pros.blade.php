{{-- Professionals --}}
<div class="row align-items-end mt-4">
    <div class="col">
        <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('record_team.PROFESSIONALS')</h6>
    </div>

    @isset($editable) {{-- Appears only if user has edit permissions --}}
    <div class="col-auto">
        <button class="btn btn-sm vbtn-main" onclick="clickManageTeamPros()"><i class="fas fa-users"></i> @lang('record_team.EDIT_PROFESSIONALS')</button>
    </div>
    @endif

    <div class="col-12">
        <hr class="mt-1">
    </div>
</div>

<div id="panel_professionals_empty" class="row mt-3"
    @if(count($team->leaders) > 0 || count($team->members) > 0)
        style="display: none"
    @endif >

    <div class="col-12 text-center font-italic">
        @lang('record_team.EMPTY_PROS_MSG')
    </div>

    @isset($editable)
    <div class="col-12 text-center mt-1">
        <button class="btn btn-sm vbtn-main" onclick="clickManageTeamPros()"><i class="fas fa-users"></i> @lang('record_team.BTN_EMPTY_PROS')</button>
    </div>
    @endif

</div>

<div id="panel_pros_leaders_list" class="row"
    @if(count($team->leaders) == 0)
        style="display: none"
    @endif >

    <div class="col-12 offset-0
                col-md-10 offset-md-1">
        <h6 class="h6 font-weight-light">@lang('record_team.TEAM_LEADERS')</h6>
    </div>

    <div id="list_pros_leaders" class="col-12 offset-0
                                       col-md-10 offset-md-1">
        {{-- Append list here through JS --}}
        @foreach($team->leaders as $uiPro)
            {!! $uiPro !!}
        @endforeach

    </div>
</div>

<div id="panel_pros_members_list" class="row mt-3"
    @if(count($team->members) == 0)
        style="display: none"
    @endif >

    <div class="col-12 offset-0
                col-md-10 offset-md-1">
        <h6 class="h6 font-weight-light">@lang('record_team.TEAM_MEMBERS')</h6>
    </div>

    <div id="list_pros_members" class="col-12 offset-0
                                       col-md-10 offset-md-1">
        {{-- Append list here through JS --}}
        @foreach($team->members as $uiPro)
            {!! $uiPro !!}
        @endforeach

    </div>
</div>
{{-- Professionals --}}

{{-- View professional modal --}}
<div id="md_view_pro" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                @component('widgets.panel_error')
                    @slot('id') panel_view_pro_error @endslot
                @endcomponent

                @component('widgets.panel_loading')
                    @slot('id') panel_view_pro_loading @endslot
                @endcomponent

                <div id="panel_view_pro_record" class="row">
                    <div id="pro_record" class="col-12 m-1">
                        {{-- Append professional record here --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm vbtn-main" data-dismiss="modal"">{{ ucfirst(trans('generic.CLOSE')) }}</button>
            </div>
        </div>
    </div>
</div>
{{-- View professional modal --}}

{{-- Manage Professionals Modal--}}
@isset($editable) {{-- Is drawn only if user has edit permissions --}}
<div id="md_manage_pros" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="h5 modal-title">@lang('record_team.MD_PROS_TITLE')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @component('widgets.panel_error')
                    @slot('id') panel_manage_pros_error @endslot
                @endcomponent

                @component('widgets.panel_loading')
                    @slot('id') panel_manage_pros_loading @endslot
                @endcomponent

                @component('widgets.panel_empty')
                    @slot('id') panel_manage_pros_empty @endslot
                @endcomponent

                <div id="panel_manage_pros_list" class="row">
                    <div class="col-12 text-center">
                        <div class="overflow-auto position-relative my-1" style="min-height: 40vh">
                            <div id="list_manage_pros" class="position-absolute w-100">
                            {{-- Append list here through JS. Must remain empty --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <div id="fb_manage_pros_req_writer" class="invalid-feedback text-right">
                    @lang('record_team.MD_PROS_REQ_WRITER')
                </div>

                <button type="button" class="btn btn-sm vbtn-support" onclick="resetProList()">{{ ucfirst(trans('generic.CANCEL')) }}</button>
                <button id="btn_manage_pros_save" onclick="submitListOfPros()" type="button" class="btn btn-sm vbtn-main">@lang('record_team.BTN_SAVE')</button>
            </div>
        </div>
    </div>
</div>
@endif
{{-- Manage Professionals Modal--}}
