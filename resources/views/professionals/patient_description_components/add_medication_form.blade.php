<div id="add_med_form">
    <div class="row">
        <div class="col-12 col-md-7
                    text-left col-vcenter">
                    <h3 class="h3 text-wrap text-break">@lang('pg_patient_description.ADD_MEDICATION_TTL')</</h3>
                    <h6 class="h6 font-weight-light text-wrap text-break">@lang('pg_patient_description.ADD_MEDICATION_DESC')</</h6>
                    
                    
        </div>
        <div class="col-12 col-md-5
                    text-center col-vcenter">
            <img class="mx-auto"  src="{{ asset('images/illustrations/add_medication.png') }}" style="height:auto;width:140px;">
        </div>
    </div>
    
    <div class="row align-items-end mt-3">
        <div class="col">
            <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.MEDICATION_FORM_GROUP_TTL_1')</h6>
        </div>
        <div class="col-12">
            <hr class="mt-1">
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-5">
            <label for="med_name">@lang('pg_professionals.MEDICATION_NAME')</label>
            <input type="text" value="" class="form-control " name="med_name" id="med_name" >
        </div> 
        <div class="col-12 col-md-3">
        {{-- dosage--}}
            <label for="med_dosage">@lang('pg_professionals.MEDICATION_DOSAGE')</label>
            <input type="number" min="0" value="0" class="form-control " name="med_dosage" id="med_dosage" >
        </div>
        <div class="col-12 col-md-4">
        {{--type--}}
            <label for="med_type">@lang('pg_professionals.MEDICATION_TYPE')</label>
            <select name="med_type" id="med_type" class="form-control" >
            <option value="10">@lang('health.MED_TYPE_CAPSULE')</option>
                <option value="20">@lang('health.MED_TYPE_PILL')</option>
                <option value="30">@lang('health.MED_TYPE_SYRUP')</option>
                <option value="40">@lang('health.MED_TYPE_SUPPOSITORY')</option>
                <option value="31">@lang('health.MED_TYPE_LIQUID')</option>
                <option value="21">@lang('health.MED_TYPE_TABLET')</option>
                <option value="50">@lang('health.MED_TYPE_TOPICAL')</option>
                <option value="51">@lang('health.MED_TYPE_DROPS')</option>
                <option value="60">@lang('health.MED_TYPE_INHALER')</option>
                <option value="70">@lang('health.MED_TYPE_INJECTION')</option>
                <option value="61">@lang('health.MED_TYPE_IMPLANT_PATCH')</option>
                <option value="22">@lang('health.MED_TYPE_BUCCAL')</option>
                <option value="99">@lang('health.MED_TYPE_OTHER')</option>
            </select>
            
        </div>
        <div class="col-12 ">
            <div class="row align-items-end mt-3">
                <div class="col">
                    <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.MEDICATION_FORM_GROUP_TTL_2')</h6>
                </div>
                <div class="col-12">
                    <hr class="mt-1">
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-4 text-left">
                    {{-- number of takings--}}
                    <label for="med_number_of_takings"> @lang('pg_professionals.NUMBER_OF_TAKINGS')</label>
                    <div class="row">
                        <div class="col">
                            <button class="periodicity-toggle" onclick="addToNumberOfTakings()">+</button>
                        </div>
                        <div class="col">
                            <span id="med_number_of_takings">1</span>
                        </div>
                        <div class="col">
                            <button class="periodicity-toggle" onclick="subtractFromNumberOfTakings()">-</button>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 text-left offset-0 offset-md-2 ">
                    {{-- periodicity--}}
                    <label for="med_periodicity">@lang('pg_professionals.PERIODICITY_LBL')</label>
                    <div class="row">
                        <div class="col">
                            <button class="periodicity-toggle" onclick="addToPeriodicity()">+</button>
                        </div>
                        <div class="col">
                            <span id="med_periodicity">1</span>
                        </div>
                        <div class="col">
                            <button class="periodicity-toggle" onclick="subtractFromPeriodicity()">-</button>
                        </div>
                    </div>
                </div>
            </div>
            <input id="amount_to_take_lbl_val" type="text" value="@lang('pg_professionals.AMOUNT_TO_TAKE_LBL')" style="display:none">
            <input id="hours_to_take_lbl_val" type="text" value="@lang('pg_professionals.HOURS_TO_TAKE_LBL')" style="display:none">
            <input id="minutes_to_take_lbl_val" type="text" value="@lang('pg_professionals.MINS_TO_TAKE_LBL')" style="display:none">
            <div id="med_taking_entries" style="width:100%;height:100%;">
                    @component('professionals.patient_description_components.new_taking_in_form')
                    @endcomponent
            </div>
        </div>
        <div class="col-12">
            <div class="row align-items-end mt-3">
                <div class="col">
                    <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.MEDICATION_FORM_GROUP_TTL_3')</h6>
                </div>
                <div class="col-12">
                    <hr class="mt-1">
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6" id="med_duration_container">
            <label id="med_treatment_duration_error" style="color:red;display:none">Invalid treatment duration</label>
            <div class="row">
                <div class="col-5">
                    <div class="custom-control custom-radio">
                        <input id="undefined_treatment_duration" class="custom-control-input" checked type="radio" name="treatment_duration" value="undefined">
                        <label for="undefined_treatment_duration" class="custom-control-label">@lang('pg_professionals.FOREVER')</label>
                    </div>
                </div>
                <div class="col-7">
                    <div class="custom-control custom-radio">
                        <input id="defined_treatment_duration" class="custom-control-input" type="radio" name="treatment_duration" value="defined">
                        <label for="defined_treatment_duration" class="custom-control-label">@lang('pg_professionals.SET_ENDDATE')</label>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="collapse multi-collapse mt-2" id="treatment_duration_collapse">
                <div class="card card-body">
                    <label for="med_treatment_duration">@lang('pg_professionals.MEDICATION_DURATION_IN_DAYS')</label>
                    <input type="number" min="0" value="0" class="form-control " name="med_treatment_duration" id="med_treatment_duration" >
                </div>
            </div>
        </div>
    </div>
</div> 

<div id="add_med_success" class="row" style="display:none">
    <div class="col-12 text-center">
        @component('widgets.panel_success')
        @slot('id') add_pat_med @endslot
        @slot('success_msg') Successfully prescribed medication @endslot
        @slot('visible') true @endslot
        @endcomponent
    </div>
</div>
<div id="add_med_error" class="row" style="display:none">
    <div class="col-12 text-center">
        @component('widgets.error_component')
        @slot('error_msg') Oops, something happened @endslot
        @endcomponent
    </div>
</div>
<div id="add_med_loading" class="row" style="display:none">
    <div class="col-12 text-center">
        @component('widgets.panel_loading')
            @slot('id') add_med_loading @endslot
        @endcomponent
    </div>
</div>

