<div class="row mx-lg-3">

    <div class="col-12 mt-5">
        <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.SECTION_ACCOUNT')</h6>
        <hr class="mt-1">
    </div>

    {{-- Username --}}
    <div class="col-12 mt-3
                col-sm-6">
        <h6 class="h6 font-weight-light">@lang('pg_patient_description.USERNAME')</h6>

        <h6 class="h6 text-break" type="text">
            @if(isset($p_profile->name))
                {{ $p_profile->name }}
            @else
                @lang('pg_patient_description.EMPTY_FIELD')
            @endif
        </h6>
    </div>
    {{-- Username --}}

    {{-- Phone --}}
    <div class="col-12 mt-3
                col-sm-6">
        <h6 class="h6 font-weight-light">@lang('pg_patient_description.PHONE')</h6>
        <h6 class="h6 text-break" type="text">
            @if(isset($p_profile->phone))
                {{ $p_profile->phone }}
            @else
                @lang('pg_patient_description.EMPTY_FIELD')
            @endif
        </h6>
    </div>
    {{-- Phone --}}

    {{-- Email --}}
    <div class="col-12 mt-3
                col-sm-6">
        <h6 class="h6 font-weight-light">@lang('pg_patient_description.EMAIL')</h6>
        <h6 class="h6 text-break">
            @if(isset($p_profile->email))
                {{ $p_profile->email }}
            @else
                @lang('pg_patient_description.EMPTY_FIELD')
            @endif
        </h6>
    </div>
    {{-- Email --}}




    <div class="col-12 mt-5">
        <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.SECTION_GENERAL')</h6>
        <hr class="mt-1">
    </div>

    {{-- Gender --}}
    <div class="col-12 mt-3
                col-sm-6">
        <h6 class="h6 font-weight-light">@lang('pg_patient_description.GENDER')</h6>
        <div class="form-group mt-2 mb-0">
            <select id="in_gender" name="in_gender" class="form-control">
                <option value="unspecified" @if(!isset($p_profile->gender) || $p_profile->gender == App\Models\Patient::GENDER_UNSPECIFIED) selected @endif >@lang('generic.GENDER_UNDEFINED')</option>
                <option value="m" @if(isset($p_profile->gender) && $p_profile->gender == App\Models\Patient::GENDER_MALE) selected @endif >{{ ucwords(trans('generic.GENDER_MALE')) }}</option>
                <option value="f" @if(isset($p_profile->gender) && $p_profile->gender == App\Models\Patient::GENDER_FEMALE) selected @endif >{{ ucwords(trans('generic.GENDER_FEMALE')) }}</option>
            </select>
        </div>
        <div><div id="in_gender_fb" class="invalid-feedback"></div></div>
    </div>
    {{-- Gender --}}

    {{-- Weight --}}
    <div class="col-12 mt-3
                col-sm-6">

        <h6 class="h6 font-weight-light">@lang('pg_patient_description.WEIGHT')</h6>
        <div class="form-group mt-2 mb-0">
            <input id="in_weight" name="in_weight" type="number" min="1" max="500" class="form-control" placeholder="@lang('pg_patient_description.WEIGHT')"
                @if(isset($p_profile->weight)) value="{{ $p_profile->weight }}" @endif >
        </div>
        <div><div id="in_weight_fb" class="invalid-feedback"></div></div>

    </div>
    {{-- Weight --}}

    {{-- Date of Birth --}}
    <div class="col-12 mt-3
                col-sm-6">
        <div>
            <h6 class="h6 font-weight-light">@lang('pg_patient_description.DATE_OF_BIRTH')</h6>
            <div class="form-group mt-2 mb-0">
                <div class="row">
                    <div class="col-3 pr-0">
                        <input id="in_b_day" name="in_b_day" type="number" min="1" max="31" class="form-control" placeholder="@lang('generic.DAY_PH')"
                            @if(isset($p_profile->b_day)) value="{{ $p_profile->b_day }}" @endif >
                    </div>
                    <div class="col-3 px-1">
                        <input id="in_b_month" name="in_b_month" type="number" min="1" max="12" class="form-control" placeholder="@lang('generic.MONTH_PH')"
                            @if(isset($p_profile->b_month)) value="{{ $p_profile->b_month }}" @endif >
                    </div>
                    <div class="col-6 pl-0">
                        <input id="in_b_year" name="in_b_year" type="number" min="1900" max="3000" class="form-control" placeholder="@lang('generic.YEAR_PH')"
                            @if(isset($p_profile->b_year)) value="{{ $p_profile->b_year }}" @endif >
                    </div>
                </div>
            </div>
            <div><div id="in_b_day_fb" class="invalid-feedback"></div></div>
            <div><div id="in_b_month_fb" class="invalid-feedback"></div></div>
            <div><div id="in_b_year_fb" class="invalid-feedback"></div></div>
        </div>

        <div class="mt-3">
            <h6 class="h6 font-weight-light">@lang('pg_patient_description.AGE')</h6>
            <h6 id="txt_age" class="h6 text-break ml-2" type="text">
                @if(isset($p_profile->age))
                    {{ $p_profile->age }}
                @else
                    @lang('pg_patient_description.EMPTY_FIELD')
                @endif
            </h6>
        </div>

    </div>
    {{-- Date of Birth --}}


    {{-- Blood Type --}}
    <div class="col-12 mt-3
                col-sm-6">
        <h6 class="h6 font-weight-light">@lang('pg_patient_description.BLOOD_TYPE')</h6>
        <div class="form-group mt-2 mb-0">
            <select id="in_blood_type" name="in_blood_type" class="form-control">
                <option value="unspecified" @if(!isset($p_profile->blood_type) || $p_profile->blood_type == App\Models\Patient::BLOOD_UNSPECIFIED) selected @endif >{{ ucwords(trans('health.BLOOD_UNSPECIFIED')) }}</option>
                <option value="a_pos" @if(isset($p_profile->blood_type) && $p_profile->blood_type == App\Models\Patient::BLOOD_A_POS) selected @endif >{{ ucwords(trans('health.BLOOD_A_POS')) }}</option>
                <option value="a_neg" @if(isset($p_profile->blood_type) && $p_profile->blood_type == App\Models\Patient::BLOOD_A_NEG) selected @endif >{{ ucwords(trans('health.BLOOD_A_NEG')) }}</option>
                <option value="b_pos" @if(isset($p_profile->blood_type) && $p_profile->blood_type == App\Models\Patient::BLOOD_B_POS) selected @endif>{{ ucwords(trans('health.BLOOD_B_POS')) }}</option>
                <option value="b_neg" @if(isset($p_profile->blood_type) && $p_profile->blood_type == App\Models\Patient::BLOOD_B_NEG) selected @endif>{{ ucwords(trans('health.BLOOD_B_NEG')) }}</option>
                <option value="o_pos" @if(isset($p_profile->blood_type) && $p_profile->blood_type == App\Models\Patient::BLOOD_O_POS) selected @endif>{{ ucwords(trans('health.BLOOD_O_POS')) }}</option>
                <option value="o_neg" @if(isset($p_profile->blood_type) && $p_profile->blood_type == App\Models\Patient::BLOOD_O_NEG) selected @endif>{{ ucwords(trans('health.BLOOD_O_NEG')) }}</option>
                <option value="ab_pos" @if(isset($p_profile->blood_type) && $p_profile->blood_type == App\Models\Patient::BLOOD_AB_POS) selected @endif>{{ ucwords(trans('health.BLOOD_AB_POS')) }}</option>
                <option value="ab_neg" @if(isset($p_profile->blood_type) && $p_profile->blood_type == App\Models\Patient::BLOOD_AB_NEG) selected @endif>{{ ucwords(trans('health.BLOOD_AB_NEG')) }}</option>
            </select>
        </div>
        <div><div id="in_blood_type_fb" class="invalid-feedback"></div></div>
    </div>
    {{-- Blood Type --}}


    <div class="col-12 mt-5">
        <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_patient_description.SECTION_OTHER')</h6>
        <hr class="mt-1">
    </div>

    {{-- Diagnoses Diseases --}}
    <div class="col-12 mt-3">

        <h6 class="h6 font-weight-light">@lang('pg_patient_description.DIAGNOSED')</h6>
        <div class="form-group mt-2 mb-0">
            <textarea id="in_diagnosed" name="in_diagnosed" class="form-control" rows="5" maxlength="1000">@if(isset($p_profile->diagnosed)){{ $p_profile->diagnosed }}@endif</textarea>
        </div>
        <div><div id="in_diagnosed_fb" class="invalid-feedback"></div></div>

    </div>
    {{-- Diagnoses Diseases --}}

    {{-- Other Conditions --}}
    <div class="col-12 mt-3">

        <h6 class="h6 font-weight-light">@lang('pg_patient_description.OTHER_CONDITIONS')</h6>
        <div class="form-group mt-2 mb-0">
            <textarea id="in_other" name="in_other" class="form-control" rows="5" maxlength="1000">@if(isset($p_profile->other)){{ $p_profile->other }}@endif</textarea>
        </div>
        <div><div id="in_other_fb" class="invalid-feedback"></div></div>

    </div>
    {{-- Other Conditions --}}

    <div class="col-12 text-right mt-3">
        <button id="btn_update_profile" class="btn vbtn-main ld-ext-right hovering" onClick="updatePatientProfile('{{ $p_profile->user_id }}')">
            @lang('pg_patient_description.BTN_SAVE_PROFILE')
            <div class="ld ld-ring ld-spin-fast"></div>
        </button>
    </div>

</div>