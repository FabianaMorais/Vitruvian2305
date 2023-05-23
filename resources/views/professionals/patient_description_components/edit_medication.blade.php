<div class="row px-3">
    <div class="col-12">
        <h4 class="h4 vpg-desc mb-3">@lang('pg_professionals.EDITING_MEDICATION_TTL')</h4>
    </div>
    <div class="col-12">
        <input type="text" id="edit_med_id" style="display:none;">
        <label for="edit_med_name">@lang('pg_professionals.MEDICATION_NAME')</label>
        <input type="text" value="" class="form-control " name="edit_med_name" id="edit_med_name" >
    </div> 
    <div class="col-12">
    {{-- dosage--}}
        <label for="edit_med_dosage">@lang('pg_professionals.MEDICATION_DOSAGE')</label>
        <input type="number" min="0" value="0" class="form-control " name="edit_med_dosage" id="edit_med_dosage" >
    </div>
    <div class="col-12">
    {{--type--}}
        <label for="edit_med_type">@lang('pg_professionals.MEDICATION_TYPE')</label>
        <select name="edit_med_type" id="edit_med_type" class="form-control" >
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
            <div class="col-12 text-left">
                {{-- number of takings--}}
                <label for="edit_med_number_of_takings"> @lang('pg_professionals.NUMBER_OF_TAKINGS')</label>
                <div class="row">
                    <div class="col">
                        <button class="periodicity-toggle" onclick="editAddToNumberOfTakings()">+</button>
                    </div>
                    <div class="col">
                        <span id="edit_med_number_of_takings">1</span>
                    </div>
                    <div class="col">
                        <button class="periodicity-toggle" onclick="editSubtractFromNumberOfTakings()">-</button>
                    </div>
                </div>
            </div>
            <div class="col-12 text-left ">
                {{-- periodicity--}}
                <label for="edit_med_periodicity">@lang('pg_professionals.PERIODICITY_LBL')</label>
                <div class="row">
                    <div class="col">
                        <button class="periodicity-toggle" onclick="editAddToPeriodicity()">+</button>
                    </div>
                    <div class="col">
                        <span id="edit_med_periodicity">1</span>
                    </div>
                    <div class="col">
                        <button class="periodicity-toggle" onclick="editSubtractFromPeriodicity()">-</button>
                    </div>
                </div>
            </div>
        </div>
        <input id="edit_amount_to_take_lbl_val" type="text" value="@lang('pg_professionals.AMOUNT_TO_TAKE_LBL')" style="display:none">
        <input id="edit_hours_to_take_lbl_val" type="text" value="@lang('pg_professionals.HOURS_TO_TAKE_LBL')" style="display:none">
        <input id="edit_minutes_to_take_lbl_val" type="text" value="@lang('pg_professionals.MINS_TO_TAKE_LBL')" style="display:none">
        <div id="edit_med_taking_entries" style="width:100%;height:100%;">
                @component('professionals.patient_description_components.new_taking_in_form')
                    @slot('edit') true @endslot
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
    <div class="col-12 " id="med_duration_container">
        <label id="edit_med_treatment_duration_error" style="color:red;display:none">Invalid treatment duration</label>
        <div class="row">
            <div class="col-5">
                <div class="custom-control custom-radio">
                    <input id="edit_undefined_treatment_duration" class="custom-control-input" type="radio" name="edit_treatment_duration" value="undefined">
                    <label for="edit_undefined_treatment_duration" class="custom-control-label">@lang('pg_professionals.FOREVER')</label>
                </div>
            </div>
            <div class="col-7">
                <div class="custom-control custom-radio">
                    <input id="edit_defined_treatment_duration" class="custom-control-input" type="radio" name="edit_treatment_duration" value="defined">
                    <label for="edit_defined_treatment_duration" class="custom-control-label">@lang('pg_professionals.SET_ENDDATE')</label>
                    
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="collapse multi-collapse mt-2" id="edit_treatment_duration_collapse">
            <div class="card card-body">
                <label for="edit_med_treatment_duration">@lang('pg_professionals.MEDICATION_DURATION_IN_DAYS')</label>
                <input type="number" min="0" value="0" class="form-control " name="edit_med_treatment_duration" id="edit_med_treatment_duration" >
            </div>
        </div>
    </div>
    <div class="col-12 mt-4 text-right">
        <button id="med_close_edit_btn" type="button" class="btn btn-sm vbtn-support" onclick="closeMedEdition()">Close</button>
        <button id="med_save_save_btn" onclick="editMedicationReq()" type="button" class="btn btn-sm vbtn-main">Save</button>
    </div>
</div>
