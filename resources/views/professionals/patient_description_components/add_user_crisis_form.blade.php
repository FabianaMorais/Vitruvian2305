



<div id="add_crisis_form" >
    <div class="row">
        <div class="col-12 col-md-7
                    text-left col-vcenter">
                    <h3 class="h3 text-wrap text-break">@lang('pg_patient_description.ADD_CRISIS_TTL')</</h3>
                    <h6 class="h6 font-weight-light text-wrap text-break">@lang('pg_patient_description.ADD_CRISIS_DESC')</</h6>
                    
                    
        </div>
        <div class="col-12 col-md-5
                    text-center col-vcenter">
            <img class="h-100 mx-auto"  src="{{ asset('images/illustrations/add_user_crisis.png') }}" style="height:auto;width:180px;">
        </div>
    </div>
    <div class="row align-items-end mt-3">
        <div class="col">
            <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.CRISIS_EVENT_DESCRIPTION')</h6>
        </div>
        <div class="col-12">
            <hr class="mt-1">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {{-- name--}}
            <div class="input-group mb-3">
                <select class="custom-select" id="crisis_id" name="crisis_id">
                    <option value="3">Tonic-clonic epileptic seizure</option>
                    <option value="4">Loss of balance</option>
                    <option value="5">Loss of consciousness</option>
                    <option value="6">Fall</option>
                    <option value="2">Absence seizure</option>
                    <option value="1">Other</option>
                </select>
            </div>
        </div> 
        

    </div>
    <div class="row align-items-end mt-3">
        <div class="col">
            <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.CRISIS_EVENT_DATETIME')</h6>
        </div>
        <div class="col-12">
            <hr class="mt-1">
        </div>
    </div>
    <div class="row">
        {{--datetime--}}
        <div class="col-4 col-md-3">
            <label for="crisis_day">@lang('pg_professionals.CRISIS_DAY')</label>
            <input type="number" min="0"  max="31"  class="form-control " name="crisis_day" id="crisis_day" >
        </div>
        <div class="col-4 col-md-3">
            <label for="crisis_month">@lang('pg_professionals.CRISIS_MONTH')</label>
            <input type="number" min="0"  max="12"  class="form-control " name="crisis_month" id="crisis_month" >
        </div>
        <div class="col-4 col-md-4">
            <label for="crisis_year">@lang('pg_professionals.CRISIS_YEAR')</label>
            <input type="number" min="1950"   class="form-control " name="crisis_year" id="crisis_year" >
        </div>
        {{-- 
        <div class="col-12 col-md-6">
            <label for="crisis_date">@lang('pg_professionals.CRISIS_DATE')</label>
            <input type="date"  class="form-control " name="crisis_date" id="crisis_date"  style="width:100%;">
        </div>
        --}}
        <div class="col-6 col-md-3 mt-2">
            <label for="crisis_hour">@lang('pg_professionals.CRISIS_HOUR')</label>
            <input type="number" min="0"  max="23"  class="form-control " name="crisis_hour" id="crisis_hour" >
        </div>
        <div class="col-6 col-md-3 mt-2">
            <label for="crisis_min">@lang('pg_professionals.CRISIS_MINUTE')</label>
            <input type="number" min="0" max="59"  class="form-control " name="crisis_min" id="crisis_min" >
        </div>
    </div>
    <div class="row align-items-end mt-3">
        <div class="col">
            <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.CRISIS_EVENT_DURATION')</h6>
        </div>
        <div class="col-12">
            <hr class="mt-1">
        </div>
    </div>
    <div class="row">
        {{--duration--}}
        <div class="col-12 col-md-6">
            <input type="number" min="0" class="form-control " name="crisis_duration" id="crisis_duration" >
        </div>
    </div>
    <div class="row align-items-end mt-3">
        <div class="col">
            <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.CRISIS_EVENT_NOTES')</h6>
        </div>
        <div class="col-12">
            <hr class="mt-1">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <textarea name="crisis_notes" class="form-control" id="crisis_notes" cols="60" rows="5" maxlength="300" style="width:100%;resize: none"></textarea>
        </div>
    </div>
</div>
<div id="add_crisis_success" class="row" style="display:none">
    <div class="col-12 text-center">
        @component('widgets.panel_success')
        @slot('id') add_pat_ce @endslot
        @slot('success_msg') Successfully added crisis event @endslot
        @slot('visible') true @endslot
        @endcomponent
    </div>
</div>
<div id="add_crisis_error" class="row" style="display:none">
    <div class="col-12 text-center">
        @component('widgets.error_component')
        @slot('error_msg') Oops, something happened @endslot
        @endcomponent
    </div>
</div>
<div id="add_crisis_loading" class="row" style="display:none">
    <div class="col-12 text-center">
        {{-- @include('widgets.loading') --}}
    </div>
</div>
