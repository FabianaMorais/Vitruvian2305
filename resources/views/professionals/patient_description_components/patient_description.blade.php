
<div class="col-12 mt-4">
    <nav>
    <div class="row">
        <div class="col-12 text-break text-center text-sm-left">
            <h2 class="h2">{{ $p_profile->full_name }}</h2>
        </div>
    </div>
    <div id="nav-tabs-patient" class="nav nav-tabs" role="tablist">
        <a class="nav-link active" id="nav-generic-tab" data-toggle="tab" href="#nav-generic" role="tab" aria-controls="nav-generic" aria-selected="true">@lang('pg_patient_description.GENERIC')</a>
        <a class="nav-link" id="nav-chart-data-tab" data-toggle="tab" href="#nav-chart-data" role="tab" aria-controls="nav-chart-data" aria-selected="false">@lang('pg_patient_description.HEALTH_SIGNALS')</a>
        <a class="nav-link" id="nav-crisis-report-tab" data-toggle="tab" href="#nav-crisis-report" role="tab" aria-controls="nav-crisis-report" aria-selected="false" @if(count($crisis_event_list) != 0) onclick="goToCrisisEvent(0)" @else onclick="showNoUserCrisisEvents()"@endif>@lang('pg_patient_description.CRISIS_REPORT')</a>
        <a class="nav-link" id="nav-profile-tab" onclick="setHideListener( '{{ $p_profile->user_id }}' )" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">@lang('pg_patient_description.PROFILE')</a>
    </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        {{--
            first page of generic info
            colored cards
            user crisis
            medication
        --}}
        <div class="tab-pane fade show active" id="nav-generic" role="tabpanel" aria-labelledby="nav-generic-tab">
            <div class="row">
                <div class="col-12 col-lg-8 col-xl-9 mt-4">
                    <div class="row mb-3">
                        <div class="col">
                            <h4 class="h4">@lang('pg_patient_description.LAST_24H')</h4>
                        </div>
                    </div>
                    <div class="row my-2 my-lg-5">
                        <div class="col-12 col-lg-4 my-2 my-lg-0">
                            <div class="row justify-content-center">
                                <div class="col-auto px-0">
                                    <img class="mx-auto" style="width: 30px;" src="{{ asset('images/illustrations/heart_rate.svg') }}">
                                </div>
                                <div class="col-auto col-vcenter">
                                    <span class="font-weight-bold">@lang('pg_patient_description.AVERAGE_BPM')</span>
                                </div>
                                <div class="col-auto col-vcenter px-0">
                                    <span id="avg_bpm_value" class="font-weight-lighter">--</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 my-2 my-lg-0">
                            <div class="row justify-content-center">
                                <div class="col-auto px-0">
                                    <img class="mx-auto" style="width: 30px;" src="{{ asset('images/illustrations/stethoscope.svg') }}">
                                </div>
                                <div class="col-auto col-vcenter">
                                    <span class="font-weight-bold">@lang('pg_patient_description.PATIENT_PROFESSIONALS_CARD_TTL')</span>
                                </div>
                                <div class="col-auto col-vcenter px-0"  data-toggle="collapse" data-target="#collapseOverseenBy" aria-expanded="false" aria-controls="collapseOverseenBy" style="cursor: pointer;">
                                    <i id="patient_professionals_caret" class="fas fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 my-2 my-lg-0">
                            <div class="row justify-content-center">
                                <div class="col-auto px-0">
                                    <img class="mx-auto" style="width: 30px;" src="{{ asset('images/illustrations/patient_team.svg') }}">
                                </div>
                                <div class="col-auto col-vcenter">
                                    <span class="font-weight-bold">@lang('pg_patient_description.PATIENT_TEAMS_CARD_TTL'):</span>
                                </div>
                                <div class="col-auto col-vcenter px-0" data-toggle="collapse" data-target="#collapseTeams" aria-expanded="false" aria-controls="collapseTeams" style="cursor: pointer;">
                                    <i id="patient_teams_caret" class="fas fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                        

                        
                        <div class="col-12 mt-2">
                            <div class="collapse" id="collapseOverseenBy">
                                @if( count($patient_professionals) == 0 ) 
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col col-vcenter text-break">
                                                @lang('pg_patient_description.NONE')
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    @foreach($patient_professionals as $professional)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-auto col-vcenter">
                                                    <img class="rounded-circle my-1" style="width: 35px; height: 35px; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $professional->avatar) }}">
                                                </div>
                                                <div class="col col-vcenter text-break">
                                                    @if(Auth::user()->id == $professional->key)
                                                        @lang('pg_patient_description.YOU')
                                                    @else
                                                        {{ $professional->name }}
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        
                        <div class="col-12 mt-2">
                            <div class="collapse" id="collapseTeams">
                                
                                @if( count($patient_teams) == 0 ) 
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col col-vcenter text-break">
                                                @lang('pg_patient_description.NONE')
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    @foreach($patient_teams as $team)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col col-vcenter text-break">
                                                    {{ $team->name }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    
                    
                    {{--second row --}}
                    <div class="row mt-2 pl-0 pl-md-4 justify-content-center">
                        {{--first row of charts  --}}
                        <div id="user_crisis_pie_chart_container" class="col-12 col-md-8 col-lg-5 card py-2 mb-2 ml-0 ml-lg-4 col-vcenter">
                                {{--user crisis events pie chart--}}
                                @component('widgets.pie_chart')
                                @slot('chart_title') User crisis events @endslot 
                                @slot('canvas_id') u_c_e_vs_time_intervals_chart @endslot
                                @slot('legend_1_id') u_c_e_legend_1 @endslot
                                @slot('legend_1_text') 24 hours @endslot
                                @slot('legend_2_id') u_c_e_legend_2 @endslot
                                @slot('legend_2_text') 7 days @endslot
                                @slot('legend_3_id') u_c_e_legend_3 @endslot
                                @slot('legend_3_text') 30 days @endslot
                                @slot('legend_4_id') u_c_e_legend_4 @endslot
                                @slot('legend_4_text') 1 year @endslot
                                @slot('legend_5_id') u_c_e_legend_5 @endslot
                                @slot('legend_5_text') Other @endslot
                                @endcomponent
                        </div>
                        @if(count($crisis_event_list) == 0)
                            <div class="col-12 offset-0 card py-2 mb-2 ">
                        @else
                        <div class="col-12 col-md-8 col-lg-5 offset-0 offset-lg-1 card py-2 mb-2 ">
                        @endif
                            @component('professionals.patient_description_components.last_3_crisis_events_component', ['crisis_event_list' => $crisis_event_list])
                            @endcomponent
                        </div>
                    </div>
                </div>
                {{--medication column --}}
                <div class="col-12 col-lg-4 col-xl-3 mt-4 mt-md-2 border-left border-light border-left-lightgray" style="border-color:lightgray !important;">
                    <div id="pat_desc_med_tab" class="row justify-content-end">
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm vbtn-main" data-toggle="modal" data-target="#addMedModal">
                                @lang('pg_patient_description.ADD_MEDICATION')
                            </button>
                        </div>
                        <div class="col-12">
                            @component('professionals.patient_description_components.medication_management', ['daily_medication_schedule' => $daily_medication_schedule,'patient_medication' => $patient_medication])
                            @endcomponent
                        </div>
                    </div>
                    <div id="edit_med_tab" class="row" style="display:none;">
                        @include('professionals.patient_description_components.edit_medication')
                    </div>
                    {{-- loading --}}
                    @component('widgets.panel_loading')
                        @slot('id') edit_med_loading @endslot
                    @endcomponent
                </div>
            </div>
        </div>
        {{--
            second page of sensor data charts
        --}}
        <div class="tab-pane fade" id="nav-chart-data" role="tabpanel" aria-labelledby="nav-chart-data-tab">
            <div class="col-12 mt-4">
                <div class="row mt-2 pl-0 pl-md-4 text-right">
                    <div class="col">
                        <input type="text" id="daterangepicker" name="daterange" value="" style="width:220px;"/>
                        <button class="btn vbtn-pop btn-sm" type="button" onclick="redrawChartsForPatDesc()">
                            <i class="fas fa-search"></i>
                        </button>    
                    </div>
                        
            
                    <hr>
                        
                </div>
            </div>
            {{--error--}}
            @component('widgets.panel_error')
                @slot('id') chart_content_error @endslot
                @slot('error_msg') An error occurred. Please try again. @endslot 
            @endcomponent
            <div id="sensor_data_charts_container" class="col-12">

                
                
                
                <div class="row justify-content-center px-0 mx-0">
                    <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                        <div id="dash_eda_chart_container"></div>
                    </div>
                    <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                        <div id="dash_ppg_chart_container"></div>
                    </div>
                    <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                        <div id="dash_adxl_chart_container"></div>
                    </div>
                    <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                        <div id="dash_heart_rate_chart_container"></div>
                    </div>
                    <div class="col-12 col-md-8 col-xl-6 my-2" style="height:300px; width:100%;">
                        <div id="dash_temperature_chart_container"></div>
                    </div>

                </div>
            </div>
            <div id="no_sensor_data_charts_container" class="col-12" style="display:none">
            @component('widgets.illustration_panel_h')
                @slot('id') search_illustration @endslot
                @slot('title') @lang('pg_patient_description.NO_COLLECTED_DATA_TTL') @endslot
                @slot('desc_1') @lang('pg_patient_description.NO_COLLECTED_DATA_DESC') @endslot
                @slot('illustration') no_chart_data.png @endslot
            @endcomponent
            </div>
        </div>
        {{--
            user crisis report
        --}}
        <div class="tab-pane fade" id="nav-crisis-report" role="tabpanel" aria-labelledby="nav-crisis-report-tab" >
            <div class="row">
                <div class="col-12">
                    <div id="crisis_list_container" class="container">
                    </div>
                    {{-- loading --}}
                    @component('widgets.panel_loading')
                        @slot('id') list_loading_container @endslot
                    @endcomponent
                    <div id="list_error_container" class="container" style="display:none">
                        {{--error--}}
                        @component('widgets.panel_error')
                            @slot('id') uc_error_container @endslot
                            @slot('error_msg') Oops something happened @endslot 
                        @endcomponent
                    </div>
                    <div id="crisis_list_no_data" class="container" style="display:none">
                    @component('widgets.illustration_panel_h')
                        @slot('id') search_illustration @endslot
                        @slot('title') @lang('pg_patient_description.NO_USER_CRISIS_TTL') @endslot
                        @slot('desc_1') @lang('pg_patient_description.NO_USER_CRISIS_DESC') @endslot
                        @slot('illustration') no_user_crisis.png @endslot
                        @slot('btns') <a class="btn vbtn-main btn-sm" data-toggle="modal" data-target="#addCrisisModal" style="color:white;">@lang('generic.ADD_NEW')</a>  @endslot
                    @endcomponent
                    </div>
                </div>
            </div>
        </div>

        {{-- 
        
            PROFILE

        --}}
        <div id="nav-profile" class="tab-pane fade" role="tabpanel" aria-labelledby="nav-profile-tab" >
            <div class="row">
                <div class="col-12">
                    @include('professionals.patient_description_components.tab_profile')
                </div>
            </div>
        </div>
    </div>
</div>
