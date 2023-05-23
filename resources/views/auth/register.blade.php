@extends('base.page_public')

@section('content')
    <div class="row">
        <div class="col-12
                    col-sm-10 offset-sm-1">
            <h1 class="h1 vpg-title">Vitruvian Shield <span>Registration</span></h1>
        </div>
        <div class="col-12
                    col-sm-10 offset-sm-1">
            <label class="h3 vpg-desc">@lang('pg_registry.PLEASE_CHOOSE')</label>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Setting a flag for javascript to know that we are returning from form submission errors --}}
        @if ($errors->has('type'))
            <input id="regist_with_errors" type="hidden" value="true">
        @endif

        {{-- Registration options --}}
        <div class="row my-2">
            <div class="col-12
                        col-sm-10 offset-sm-1">
                <div class="row">
        
                    <div class="col-12
                                col-md-auto offset-md-1">
                        <div class="custom-control custom-radio">
                            <input id="rb_regist_professional" class="custom-control-input" type="radio" name="rb_regist" value="professional"
                                {{-- If we return from submitting the professional form with errors, we select the radio button --}}
                                @if ($errors->has('type') && $errors->first('type') == "professional") checked @endif >
                            <label for="rb_regist_professional" class="custom-control-label">@lang('pg_registry.PROFESSIONAL')</label>
                        </div>
                    </div>

                    <div class="col-12
                                col-md-auto">
                        <div class="custom-control custom-radio">
                            <input id="rb_regist_organization" class="custom-control-input" type="radio" name="rb_regist" value="organization"
                                {{-- If we return from submitting the organization form with errors, we select the radio button --}}
                                @if ($errors->has('type') && $errors->first('type') == "organization") checked @endif >
                            <label for="rb_regist_organization" class="custom-control-label">@lang('pg_registry.ACADEMIC_ORGANIZATION')</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Registration options --}}

        {{-- Registration panels --}}
        <div class="row mb-5 justify-content-center">

            <div id="panel_regist_professional" class="col-12 col-lg-8"
                @if (!$errors->has('type') || $errors->first('type') != "professional") style="display:none" @endif >
                @include('auth.reg_form_professional')
            </div>

            <div id="panel_regist_organization" class="col-12 col-lg-8"
                @if (!$errors->has('type') || $errors->first('type') != "organization") style="display:none" @endif >
                @include('auth.reg_form_organization')
            </div>

        </div>
        {{-- Registration panels --}}

    </form>

@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/pg_register.js') }}"></script>
@endsection