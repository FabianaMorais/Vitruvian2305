@extends('base.page_app')

@section('content')
<div class="container">
        @component('widgets.panel_loading')
            @slot('id') dd_loading @endslot
        @endcomponent
        @component('widgets.panel_error')
            @slot('id') dd_error @endslot
        @endcomponent
    <div id="dd_progress_container" class="row justify-content-center col-vcenter" style="display:none;min-height:70vh;">
    <div class="col-12">
        <div class="row justify-content-center" >
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 progress mx-0 px-0 ">
                <div id="dd_progress_bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="90" style="width:0%"></div>
                <div id="dd_progress_bar_process" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10" style="width:0%"></div>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-12 col-sm-10 col-md-8 col-lg-7 text-center">
                <span>@lang('pg_professionals.FETCHING_RECORD_LBL')<span id="current_record">1</span>@lang('pg_professionals.OUT_OF_LBL')<span id="total_records"></span></span>
            </div>
        </div>
    </div>

        
        
    </div>
    @component('professionals.data_download.download_report')
    @endcomponent
    <div id="dd_content" class="row justify-content-center">
        <div class="col-12 mb-4">
            <h1 class="h1">@lang('pg_professionals.MANAGE_DATA')</h1>
        </div>
        @if(count($teams_with_patients) == 0)
            <div class="col-12">
                @component('widgets.illustration_panel_h')
                    @slot('id') no_patients_illustration @endslot
                    @slot('title') @lang('pg_professionals.NO_PATIENTS_FOR_DOWNLOAD_TTL') @endslot
                    @slot('desc_1') @lang('pg_professionals.NO_PATIENTS_FOR_DOWNLOAD_DESC') @endslot
                    @slot('illustration') download_data.png @endslot
                    @slot('btns') <a class="btn vbtn-main" href="{{ route('patients.new.form') }}">@lang('generic.ADD_NEW')</a>  @endslot
                @endcomponent
            </div>
        @else
        {{--date range and file type column--}}
            <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <label for="daterange">@lang('pg_professionals.DATE_RANGE_SELECTION_TTL')</label>
                        <input type="text" id="daterangepicker" name="daterange" value=""  class="form-control"/>
                    </div>
                    <div class="col-12 mt-4">
                        <label >@lang('pg_professionals.FILE_TYPE_SELECTION_TTL')*</label>    
                    </div>
                    <div class="col-12">
                        <div class="custom-control custom-radio">
                            <input id="file_type_json" name="file_type_selection" checked type="radio" value="json" class="custom-control-input" onclick="disableSensorSelection()">
                            <label for="file_type_json" class="custom-control-label">@lang('pg_professionals.JSON')</label>
                        </div>
                    </div>
                    <div class="col-12">
                        
                        <div class="custom-control custom-radio">
                            <input id="file_type_csv" name="file_type_selection" type="radio" value="csv" class="custom-control-input" onclick="enableSensorSelection()">
                            <label for="file_type_csv" class="custom-control-label">@lang('pg_professionals.CSV')</label>
                        </div>
                        
                        
                    </div>
                    <div class="col-12 mt-4">
                        <label>@lang('pg_professionals.CRISIS_SELECTION_TTL')</label>    
                    </div>
                    <div class="col-12">
                        <div class="form-check px-0 mx-0">
                            <div class="custom-control custom-checkbox">
                                <input value="use_submitted_by_users" id="use_submitted_by_users" type="checkbox" class="custom-control-input">
                                <label for="use_submitted_by_users" class="custom-control-label"> @lang('pg_professionals.USE_DATA_SUBMITTED_BY_USERS')</label>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
            <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <label>User selection:</label> 
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="height:250px;overflow-y:overlay;">
                                @component('professionals.data_download.user_selection', compact('teams_with_patients'))
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <label>Sensor selection:</label> 
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="height:250px;overflow-y:overlay;">
                                <ul class="list-group list-group-flush">
                                    {{-- sensor list --}}
                                    {{-- sensor 1 is accelerometer --}}
                                    <li class="list-group-item my-1 py-2">
                                        <div class="row">
                                            <div class="col-10 col-vcenter">
                                                <label class="my-0">Accelerometer</label>
                                            </div>
                                            <div class="col-2 col-vcenter mx-0 px-0">
                                                <div class="form-check">
                                                    <div class="custom-control custom-checkbox">
                                                        <input value="1" id="sensor_1" checked disabled type="checkbox" value="1" class="custom-control-input" onchange="toggleDownloadButton()">
                                                        <label for="sensor_1" class="custom-control-label"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    {{-- sensor 2 is eda --}}
                                    <li class="list-group-item my-1 py-2">
                                        <div class="row">
                                            <div class="col-10 col-vcenter">
                                                <label class="my-0">@lang('pg_professionals.SENSOR_2_NAME')</label>
                                            </div>
                                            <div class="col-2 col-vcenter mx-0 px-0">
                                                <div class="form-check">
                                                    <div class="custom-control custom-checkbox">
                                                        <input value="2" id="sensor_2" checked disabled type="checkbox" value="2" class="custom-control-input" onchange="toggleDownloadButton()">
                                                        <label for="sensor_2" class="custom-control-label"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    {{-- sensor 3 is ppg --}}
                                    <li class="list-group-item my-1 py-2">
                                        <div class="row">
                                            <div class="col-10 col-vcenter">
                                                <label class="my-0">@lang('pg_professionals.SENSOR_3_NAME')</label>
                                            </div>
                                            <div class="col-2 col-vcenter mx-0 px-0">
                                                <div class="form-check">
                                                    <div class="custom-control custom-checkbox">
                                                        <input value="3" id="sensor_3" checked disabled type="checkbox" value="3" class="custom-control-input" onchange="toggleDownloadButton()">
                                                        <label for="sensor_3" class="custom-control-label"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    {{-- sensor 4 is temperature --}}
                                    <li class="list-group-item my-1 py-2">
                                        <div class="row">
                                            <div class="col-10 col-vcenter">
                                                <label class="my-0">@lang('pg_professionals.SENSOR_4_NAME')</label>
                                            </div>
                                            <div class="col-2 col-vcenter mx-0 px-0">
                                                <div class="form-check">
                                                    <div class="custom-control custom-checkbox">
                                                        <input value="4" id="sensor_4" checked disabled type="checkbox" value="4" class="custom-control-input" onchange="toggleDownloadButton()">
                                                        <label for="sensor_4" class="custom-control-label"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item my-1 py-2">
                                        <div class="row">
                                            <div class="col-10 col-vcenter">
                                                <label class="my-0">@lang('pg_professionals.SENSOR_5_NAME')</label>
                                            </div>
                                            <div class="col-2 col-vcenter mx-0 px-0">
                                                <div class="form-check">
                                                    <div class="custom-control custom-checkbox">
                                                        <input value="5" id="sensor_5" checked disabled type="checkbox" value="5" class="custom-control-input" onchange="toggleDownloadButton()">
                                                        <label for="sensor_5" class="custom-control-label"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="col-12 col-sm-8 col-md-7 col-lg-12 mt-4">
                <span class="font-weight-light vtext-dark-gray">@lang('pg_professionals.DONWLOAD_TYPES_DESC')</span>
            </div>
            <div id="no_users_error" class="col-12 col-sm-8 col-md-7 col-lg-4 offset-0 offset-lg-8" style="display:none">
                {{-- feedback field--}}
                <span  class="text-danger text-left"><strong>@lang('pg_professionals.NO_USERS_ERROR')</strong></span>
            </div>
            <div class="col-10">
                <div class="row mt-3 justify-content-end">
                    <div class="col-auto">
                        <button id="dd_button" type="button" onclick="downloadData()" class="btn btn-sm vbtn-main">@lang('pg_professionals.DOWNLOAD')</button>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data_download.css') }}">
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/data_download.js') }}"></script>
@endsection