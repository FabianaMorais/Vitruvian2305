@extends('base.page_app')

@section('content')
<div id="pat_list_container" class="container">
    <div class="row mb-4">
        <div class="col-auto"><h1 class="h1">@lang('pg_patient_description.PG_TITLE')</h1></div>
    </div>
    {{-- patient searchbar --}}
    @component('professionals.patient_description_components.searchbar', ['patient_infos' => $patient_infos])
    @endcomponent
    {{-- loading --}}
    @component('widgets.panel_loading')
        @slot('id') loading @endslot
    @endcomponent

    <div id="dd_progress_container" class="row justify-content-center col-vcenter" style="display:none;min-height:70vh;">
        <div class="col-12">
            <div class="row justify-content-center" >
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 progress mx-0 px-0 ">
                    <div id="dashboard_progress_bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:1%"></div>
                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-12 col-sm-10 col-md-8 col-lg-7 text-center">
                    <span>@lang('pg_professionals.FETCHING_CHART_DATA')</span>
                </div>
            </div>
        </div>
    </div>


    @component('widgets.illustration_panel_h')
        @slot('id') search_illustration @endslot
        @slot('title') @lang('pg_patient_description.SEARCH_TITLE') @endslot
        @slot('desc_1') @lang('pg_patient_description.SEARCH_DESC_1') @endslot
        @slot('desc_2') @lang('pg_patient_description.SEARCH_DESC_2') @endslot
        @slot('illustration') search_patients.png @endslot
    @endcomponent
    {{--patient description page rendered on server--}}
    <div class="row" id="pat_desc_container" style="display:none;">
    </div>
    {{--error--}}
    @component('widgets.panel_error')
        @slot('id') pl_error_container @endslot
        @slot('error_msg') Oops something happened @endslot 
    @endcomponent
    
    
</div>

{{-- add medication modal --}}
<div class="modal fade" id="addMedModal" tabindex="-1" role="dialog" aria-labelledby="MedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="h5 modal-title" id="MedModalTitle">@lang('pg_professionals.MODAL_MED_TTL')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" id="new_med_form" style="display:none">
            <div id="resetable_med_form" class="modal-body">
                @component('professionals.patient_description_components.add_medication_form')
                @endcomponent
            </div>
            <div  class="modal-footer">
                <button id="med_close_btn"  type="button" class="btn btn-sm vbtn-support" data-dismiss="modal">{{ ucfirst(trans('pg_professionals.CLOSE')) }}</button>
                <button id="med_save_btn" onclick="addMedication()" type="button" class="btn btn-sm vbtn-main">@lang('pg_professionals.SAVE')</button>
            </div>
        </div>
    </div>
</div>

{{-- add crisis event modal --}}
<div class="modal fade" id="addCrisisModal" tabindex="-1" role="dialog" aria-labelledby="CrisisModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="h5 modal-title" id="CrisisModalTitle">@lang('pg_professionals.MODAL_USER_CRISIS_TTL')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="resetable_crisis_event_form" class="modal-body" id="new_crisis_event_form">
                @component('professionals.patient_description_components.add_user_crisis_form')
                @endcomponent
            </div>
            <div  class="modal-footer">
                <button id="crisis_close_btn"  type="button" class="btn btn-sm vbtn-support" data-dismiss="modal">{{ ucfirst(trans('pg_professionals.CLOSE')) }}</button>
                <button id="crisis_save_btn" onclick="addCrisisEvent()" type="button" class="btn btn-sm vbtn-main">@lang('pg_professionals.SAVE')</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/calendar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/patients.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/data_download.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/chart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/draw_charts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/medication.js') }}"></script>
    <script type="text/javascript">
        updateHealthProfileUrl = {!! json_encode(route('patients.update.health_profile'), JSON_HEX_TAG) !!};
    </script>
    <script type="text/javascript" src="{{ asset('js/patient_profile.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/form_validations.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/canvasjs.min.js') }}"></script>
    
@endsection
