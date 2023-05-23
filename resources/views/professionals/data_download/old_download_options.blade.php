@extends('base.page_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 class="h1">@lang('pg_professionals.MANAGE_DATA')</h1>
        </div>
        @if(count($patients) == 0)
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
            <div class="col-12">
                @component('widgets.illustration_panel_h')
                    @slot('id') search_illustration @endslot
                    @slot('title') @lang('pg_professionals.DOWNLOAD_DATA_TTL') @endslot
                    @slot('desc_1') @lang('pg_professionals.DOWNLOAD_DATA_DESC') @endslot
                    @slot('illustration') download_data.png @endslot
                @endcomponent
            </div>
            <div class="col-12 col-md-10 offset-0 offset-md-1">
                <form>
                    @csrf
                    <div class="form-group">
                        @if(!isset($individual))
                            {{--users--}}
                            <div class="row align-items-end mt-3">
                                <div class="col">
                                    <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_professionals.USERS')</h6>
                                </div>
                                <div class="col-12">
                                    <hr class="mt-1">
                                </div>
                            </div>
                            <div class="row" style="min-height:140px">
                                <div class="col-12
                                            col-md-3 offset-md-1">
                                    <div class="custom-control custom-radio">
                                        <input id="rb_all_patients" class="custom-control-input" checked type="radio" name="rb_patients" value="all">
                                        <label for="rb_all_patients" class="custom-control-label">@lang('pg_professionals.ALL')</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-auto
                                            col-lg-3">
                                    <div class="custom-control custom-radio">
                                        <input id="rb_patient_list" class="custom-control-input" type="radio" name="rb_patients" value="patient_list">
                                        <label for="rb_patient_list" class="custom-control-label">@lang('pg_professionals.CHOOSE')</label>
                                    </div>
                                    <span id="no_users_error" class="invalid-feedback d-none text-left" role="alert"><strong>@lang('pg_professionals.NO_USERS_ERROR')</strong></span>
                                </div>
                                <div class="col-12 col-lg-4 offset-0 offset-md-1 offset-lg-0 text-left text-lg-center py-0" >
                                    <div id="collapsePatientList" class="collapse p-0 card-container-collapse" >
                                        
                                        <div class="row collapse-content-resize">
                                            @foreach($patients as $patient) 
                                                @component('professionals.data_download.user_selection_component')
                                                    @slot('patient_name') {{ $patient->full_name }} @endslot     
                                                    @slot('patient_code') {{ $patient->inscription_code }} @endslot 
                                                @endcomponent
                                            @endforeach
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{--sensors--}}
                        <div class="row align-items-end mt-4">
                            <div class="col">
                                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_professionals.SENSOR_LIST')</h6>
                            </div>
                            <div class="col-12">
                                <hr class="mt-1">
                            </div>
                        </div>
                        <div id="no_sensors_error" class="row d-none">
                            <span  class="invalid-feedback  text-left" role="alert"><strong>@lang('pg_professionals.NO_SENSORS_ERROR')</strong></span>
                        </div>
                        <div class="row">
                            {{--sensor 2 --}}
                            @component('professionals.data_download.sensor_selection_component')
                                @slot('numeric_id') 2 @endslot
                                @slot('text') @lang('pg_professionals.SENSOR_2_NAME') @endslot
                            @endcomponent
                            {{--sensor 3 --}}
                            @component('professionals.data_download.sensor_selection_component')
                                @slot('numeric_id') 3 @endslot
                                @slot('text') @lang('pg_professionals.SENSOR_3_NAME') @endslot
                            @endcomponent
                            {{--sensor 4 --}}
                            @component('professionals.data_download.sensor_selection_component')
                                @slot('numeric_id') 4 @endslot
                                @slot('text') @lang('pg_professionals.SENSOR_4_NAME') @endslot
                            @endcomponent
                            {{--sensor 7 --}}
                            @component('professionals.data_download.sensor_selection_component')
                                @slot('numeric_id') 7 @endslot
                                @slot('text') @lang('pg_professionals.SENSOR_7_NAME') @endslot
                            @endcomponent
                            {{--sensor 9 --}}
                            @component('professionals.data_download.sensor_selection_component')
                                @slot('numeric_id') 9 @endslot
                                @slot('text') @lang('pg_professionals.SENSOR_9_NAME') @endslot
                            @endcomponent
                        </div>
                        <div class="row align-items-end mt-5">
                            <div class="col">
                                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_professionals.DATA_SELECTION')</h6>
                            </div>
                            <div class="col-12">
                                <hr class="mt-1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <div class="custom-control custom-checkbox">
                                    <input value="use_submitted_by_users" id="use_submitted_by_users" type="checkbox" class="custom-control-input">
                                    <label for="use_submitted_by_users" class="custom-control-label"> @lang('pg_professionals.USE_DATA_SUBMITTED_BY_USERS')</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-auto">
                                <button type="button" onclick="downloadData()" class="btn btn-sm vbtn-support">@lang('pg_professionals.DOWNLOAD')</button>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-sm vbtn-main" onclick="window.location.href = '{{ route('home') }}'">@lang('pg_professionals.CANCEL')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>

</div>
@endsection

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/data_download.css') }}">
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/data_download.js') }}"></script>
@endsection