@extends('base.page_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                        @component('widgets.illustration_panel_h')
                            @slot('id') search_illustration @endslot
                            @slot('title') @lang('pg_professionals.RECOVER_PASSWORD_TTL') @endslot
                            @slot('desc_1') 
                                @lang('pg_professionals.RECOVER_PASSWORD_DESC')
                            @endslot
                            @slot('desc_2') 
                                <form action="{{route('recover patient password form submit')}}" method="POST">
                                @csrf
                                {{-- email--}}
                                <input type="text" class="form-control {{ $errors->has('patient_email') ? 'is-invalid' : '' }}" name="patient_email" id="patient_email" value="{{ old('patient_email') }}">
                                @if($errors->has('patient_email')) 
                                    <div class="invalid-feedback"> 
                                {{ $errors->first('patient_email') }} 
                                    </div> 
                                @endif
                                <button type="submit" class="btn vbtn-main btn-sm mt-2">@lang('pg_professionals.SAVE')</button>
                            </form>
                            @endslot
                            @slot('illustration') recover_password.png @endslot
                        @endcomponent
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/patients.js') }}"></script>
@endsection