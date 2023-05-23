{{-- Patients --}}
<div class="row align-items-end mt-4">
    <div class="col">
        <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('record_team.PATIENTS')</h6>
    </div>

    @isset($editable) {{-- Appears only if user has edit permissions --}}
    <div class="col-auto">
        <button class="btn btn-sm vbtn-main" onclick="clickManageTeamPatients()"><i class="fas fa-user-injured"></i> @lang('record_team.EDIT_PATIENTS')</button>
    </div>
    @endif

    <div class="col-12">
        <hr class="mt-1">
    </div>
</div>

<div id="panel_patients_empty" class="row mt-3"
    @if(count($team->patients) > 0)
        style="display: none"
    @endif >

    <div class="col-12 text-center font-italic">
        @lang('record_team.EMPTY_PATIENTS_MSG')
    </div>

    @isset($editable)
    <div class="col-12 text-center mt-1">
        <button class="btn btn-sm vbtn-main" onclick="clickManageTeamPatients()"><i class="fas fa-user-injured"></i> @lang('record_team.BTN_EMPTY_PATIENTS')</button>
    </div>
    @endif

</div>

<div id="panel_patients_list" class="row mt-3"
    @if(count($team->patients) == 0)
        style="display: none"
    @endif >

    <div id="list_patients" class="col-12 offset-0
                                   col-md-10 offset-md-1">
        {{-- Append list here through JS --}}
        @foreach($team->patients as $uiPatient)
            {!! $uiPatient !!}
        @endforeach

    </div>
</div>
{{-- Patients --}}

{{-- Manage Patients Modal--}}
@isset($editable) {{-- Is drawn only if user has edit permissions --}}
<div id="md_manage_patients" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="h5 modal-title">@lang('record_team.MD_PATIENTS_TITLE')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @component('widgets.panel_error')
                    @slot('id') panel_manage_patients_error @endslot
                @endcomponent

                @component('widgets.panel_loading')
                    @slot('id') panel_manage_patients_loading @endslot
                @endcomponent

                @component('widgets.panel_empty')
                    @slot('id') panel_manage_patients_empty @endslot
                @endcomponent

                <div id="panel_manage_patients_list" class="row">
                    <div class="col-12 text-center">
                        <div class="overflow-auto position-relative my-1" style="min-height: 40vh">
                            <div id="list_manage_patients" class="position-absolute w-100">
                            {{-- Append list here through JS. Must remain empty --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm vbtn-support" onclick="resetPatientList()">{{ ucfirst(trans('generic.CANCEL')) }}</button>
                <button id="btn_manage_patients_save" onclick="submitListOfPatients()" type="button" class="btn btn-sm vbtn-main">@lang('record_team.BTN_SAVE')</button>
            </div>
        </div>
    </div>
</div>
@endif
{{-- Manage Patients Modal--}}
