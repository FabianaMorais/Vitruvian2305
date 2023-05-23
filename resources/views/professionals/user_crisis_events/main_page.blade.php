
 <div class="row mt-2">
    <div class="col text-right pb-0 pt-0 mt-0 mb-0" style="color:white;float:right;">
        <a class="btn vbtn-main btn-sm" data-toggle="modal" data-target="#addCrisisModal">@lang('generic.ADD_NEW')</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                @component('professionals.user_crisis_events.crisis_report_header')
                    @slot('name') {{$crisis_event_list[$page_to_display]->crisis_event_name}} @endslot
                    @slot('datetime') {{$crisis_event_list[$page_to_display]->crisis_date}} {{$crisis_event_list[$page_to_display]->crisis_event_time}} @endslot
                    @slot('submitted_by_doctor') {{$crisis_event_list[$page_to_display]->submitted_by_doctor}} @endslot
                    @slot('duration') {{$crisis_event_list[$page_to_display]->duration_in_seconds}} @endslot
                    @slot('page') {{$page_to_display}} @endslot
                @endcomponent
            </div>
        </div>
        <hr>
        <div id="ce_no_sensor_data" class="row mt-4 justify-content-center">
            @component('widgets.illustration_panel_h')
                @slot('id') search_illustration @endslot
                @slot('title') @lang('pg_patient_description.NO_COLLECTED_DATA_TTL') @endslot
                @slot('desc_1') @lang('pg_patient_description.NO_COLLECTED_DATA_DESC') @endslot
                @slot('illustration') no_chart_data.png @endslot
            @endcomponent
        </div>
        <div id="crisis_report_progress_container" class="row justify-content-center col-vcenter" style="display:none;min-height:70vh;">
            <div class="col-12">
                <div class="row justify-content-center" >
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 progress mx-0 px-0 ">
                        <div id="crisis_report_progress_bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:1%"></div>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-7 text-center">
                        <span>@lang('pg_professionals.FETCHING_CHART_DATA')</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="ce_sensor_data_container" class="row mt-4 justify-content-center">
                <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                    <div id="crisis_report_eda_chart_container"></div>
                </div>
                <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                    <div id="crisis_report_ppg_chart_container"></div>
                </div>
                <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                    <div id="crisis_report_adxl_chart_container"></div>
                </div>
                <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                    <div id="crisis_report_heart_rate_chart_container"></div>
                </div>
                <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                    <div id="crisis_report_temperature_chart_container"></div>
                </div>

        </div>
        <div class="row justify-content-center">
            <div class="card col-12 col-lg-4 mt-4 crisis-event-full-list-container">
                @component('professionals.patient_description_components.last_3_crisis_events_component', ['crisis_event_list' => $crisis_event_list])
                    @slot('full_list') true @endslot
                @endcomponent
            </div>
        </div>

    </div>
    
</div>
