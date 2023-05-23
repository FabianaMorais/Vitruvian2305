@extends('base.page_app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="h1">@lang('pg_patient_description.ADD_PATIENT_TTL')</h1>
        </div>
    </div>

    <div class="row my-md-5">

        <div class="col-12
                    col-sm-10 offset-sm-1
                    col-md-6 offset-md-0
                    col-lg-4 offset-lg-2
                    col-vcenter">
                @component('widgets.illustration_panel_v')
                    @slot('title') @lang('pg_patient_description.ADD_PATIENT_DESC_TTL') @endslot
                    @slot('desc_1') @lang('pg_patient_description.ADD_PATIENT_DESC_TXT') @endslot
                    @slot('illustration') add_patient.png @endslot
                @endcomponent
        </div>

        <div class="col-12
                    col-sm-10 offset-sm-1
                    col-md-6 offset-md-0
                    col-lg-4">
            @include('professionals.new_patient_form')
        </div>

    </div>

@endsection