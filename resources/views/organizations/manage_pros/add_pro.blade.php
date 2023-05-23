@extends('base.page_app')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="h1">@lang('pg_manage_pros.ADD_PRO_TITLE')</h1>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 offset-0
                    col-md-10 offset-md-1
                    col-xl-8 offset-xl-2">
            @component('professionals.record.pro_record_edit')
                @slot('postRoute') {{ route('org.manage.pros.save_new') }} @endslot
            @endcomponent
        </div>
    </div>

@endsection