
<div class="row">

    <div class="col order-2
                order-sm-1
                col-vcenter">

        <select id="searchbar" class="form-control" onchange="getPatientInfo(value);">
            
            @if(count($patient_infos) > 0)
                <option invalid hidden selected >@lang('pg_patient_description.SEARCH_BAR_PH')</option>
            @else
                <option invalid selected>@lang('pg_patient_description.SEARCH_BAR_EMPTY')</option>
            @endif

            @foreach($patient_infos as $patient_info)
                <option value="{{ $patient_info->id }}">{{ $patient_info->full_name . ' (' . $patient_info->user->name . ')' }}</option>
            @endforeach

        </select>
    </div>

    <div class="col-12 mb-3 order-1
                col-sm-auto mb-sm-0 order-sm-2
                col-vcenter">
        <a class="btn btn-sm vbtn-main" href="{{ route('patients.new.form') }}"><i class="fas fa-user-plus"></i> @lang('pg_patient_description.BTN_ADD')</a>
    </div>

</div>