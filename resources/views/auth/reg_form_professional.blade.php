<div class="card border-0">


    <div id="regist_pro_header_res" class="card-header vstyle-res"
        @if ( $errors->has('pro_type') && $errors->first('pro_type') != "researcher" ) {{-- We do not hide this if no radio button was selected. It is shown by default --}}
            style="display: none"
        @endif >
        @lang('pg_registry.PROFESSIONAL_REGIST_RES_TITLE')
    </div>
    <div id="regist_pro_header_doc" class="card-header vstyle-doc"
        @if ( !$errors->has('pro_type') || $errors->first('pro_type') != "doctor" ) {{-- We hide this if it isn't the previously selected option --}}
            style="display: none"
        @endif >
        @lang('pg_registry.PROFESSIONAL_REGIST_DOC_TITLE')
    </div>
    <div id="regist_pro_header_care" class="card-header vstyle-care"
        @if ( !$errors->has('pro_type') || $errors->first('pro_type') != "caregiver" ) {{-- We hide this if it isn't the previously selected option --}}
            style="display: none"
        @endif >
        @lang('pg_registry.PROFESSIONAL_REGIST_CARE_TITLE')
    </div>



    <div class="card-body vstyle-light">

        <div class="form-group row">
            
            <label class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PROFESSIONAL_REGIST_TYPE')</label>

            <div class="col-md-6 pt-2
                        pl-0
                        pl-sm-2
                        pl-md-0">

                <div class="form-check">
                    <div class="custom-control custom-radio">
                        <input id="rb_regist_pro_res" class="custom-control-input" type="radio" name="rb_regist_pro_type" value="researcher"
                            {{-- If we return from submitting the professional form with errors, we select the radio button --}}
                            @if ($errors->has('pro_type'))
                                @if ($errors->first('pro_type') == "researcher")
                                    checked {{-- Checked if it is the previously selected radio button --}}
                                @endif
                            @else
                                checked {{-- Checked by default if there are no pro_type errors at all --}}
                            @endif
                            >
                        <label for="rb_regist_pro_res" class="custom-control-label">@lang('pg_registry.PROFESSIONAL_TYPE_RES')</label>
                    </div>
                </div>

                <div class="form-check">
                    <div class="custom-control custom-radio">
                        <input id="rb_regist_pro_doc" class="custom-control-input" type="radio" name="rb_regist_pro_type" value="doctor"
                            {{-- If we return from submitting the professional form with errors, we select the radio button --}}
                            @if ($errors->has('pro_type') && $errors->first('pro_type') == "doctor") checked @endif >
                        <label for="rb_regist_pro_doc" class="custom-control-label">@lang('pg_registry.PROFESSIONAL_TYPE_DOC')</label>
                    </div>
                </div>

                <div class="form-check">
                    <div class="custom-control custom-radio">
                        <input id="rb_regist_pro_care" class="custom-control-input" type="radio" name="rb_regist_pro_type" value="caregiver"
                            {{-- If we return from submitting the professional form with errors, we select the radio button --}}
                            @if ($errors->has('pro_type') && $errors->first('pro_type') == "caregiver") checked @endif >
                        <label for="rb_regist_pro_care" class="custom-control-label">@lang('pg_registry.PROFESSIONAL_TYPE_CARE')</label>
                    </div>
                </div>

            </div>
        </div>

        <div class="alert alert-light mx-1 mx-lg-5" role="alert">
            <label id="regist_descript_pro_res" class="card-text"
                @if ( $errors->has('pro_type') && $errors->first('pro_type') != "researcher" ) {{-- We do not hide this if no radio button was selected. It is shown by default --}}
                    style="display: none"
                @endif >
                @lang('pg_registry.PROFESSIONAL_RESEARCHER_DESCRIPT')
            </label>

            <label id="regist_descript_pro_doc" class="card-text"
                @if ( !$errors->has('pro_type') || $errors->first('pro_type') != "doctor" )  {{-- We hide this if it isn't the previously selected option --}}
                    style="display: none"
                @endif >
                @lang('pg_registry.PROFESSIONAL_MEDICAL_DESCRIPT')
            </label>

            <label id="regist_descript_pro_care" class="card-text"
                @if ( !$errors->has('pro_type') || $errors->first('pro_type') != "caregiver" )
                    style="display: none"
                @endif >
                @lang('pg_registry.PROFESSIONAL_CAREGIVER_DESCRIPT')
            </label>
        </div>

        {{-- Username --}}
        <div class="form-group row">
            <label for="pro_name" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PROFESSIONAL_USERNAME')</label>
            <div class="col-md-6 col-vcenter">
                <input id="pro_name" name="pro_name" type="text" maxlength="80" class="form-control" value="{{ old('pro_name') }}">
                @if ($errors->has('pro_name'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('pro_name') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Username --}}

        {{-- Full Name --}}
        <div class="form-group row">
            <label for="pro_full_name" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PROFESSIONAL_NAME')</label>
            <div class="col-md-6 col-vcenter">
                <input id="pro_full_name" name="pro_full_name" type="text" maxlength="80" class="form-control" value="{{ old('pro_full_name') }}">
                @if ($errors->has('pro_full_name'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('pro_full_name') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Full Name --}}

        {{-- Email --}}
        <div class="form-group row">
            <label for="pro_email" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PROFESSIONAL_EMAIL')</label>
            <div class="col-md-6 col-vcenter">
                <input id="pro_email" name="pro_email" type="email" maxlength="80" class="form-control" value="{{ old('pro_email') }}">
                @if ($errors->has('pro_email'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('pro_email') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Email --}}

        {{-- Address --}}
        <div class="form-group row">
            <label for="pro_address" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PROFESSIONAL_ADDRESS')</label>
            <div class="col-md-6 col-vcenter">
                <input id="pro_address" name="pro_address" type="address" maxlength="160" class="form-control" value="{{ old('pro_address') }}">
                @if ($errors->has('pro_address'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('pro_address') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Address --}}

        {{-- Phone --}}
        <div class="form-group row">
            <label for="pro_phone" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PROFESSIONAL_PHONE')</label>
            <div class="col-md-6 col-vcenter">
                <input id="pro_phone" name="pro_phone" type="phone" maxlength="30" class="form-control" value="{{ old('pro_phone') }}">
                @if ($errors->has('pro_phone'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('pro_phone') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Phone --}}

        {{-- Organization selector --}}
        <div class="form-group row">
            <label for="pro_organization" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PROFESSIONAL_ORGANIZATION')</label>
            <div class="col-md-6 col-vcenter">
                <select id="pro_organization" name="pro_organization" type="text" class="form-control">
                    <option value="" disabled hidden selected>@lang('pg_registry.PROFESSIONAL_ORGANIZATION_SELECT')</option>
                    <option value="">{{ucfirst(trans('generic.OTHER_FEMALE'))}}</option>

                    @foreach($orgs_list as $o)
                        <option value="{{$o}}">{{$o}}</option>
                    @endforeach

                </select>
                @if ($errors->has('pro_organization'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('pro_organization') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Organization selector --}}
        
        {{-- Custom Organization --}}
        <div id="reg_form_pro_custom_organization" class="form-group row"
        @if (!$errors->has('pro_custom_organization')) style="display: none" @endif >
            <label for="pro_custom_organization" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PROFESSIONAL_CUSTOM_ORGANIZATION')</label>
            <div class="col-md-6 col-vcenter">
                <input id="pro_custom_organization" name="pro_custom_organization" type="text" maxlength="160" class="form-control" value="{{ old('pro_custom_organization') }}">
                @if ($errors->has('pro_custom_organization'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('pro_custom_organization') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Custom Organization --}}

        {{-- Password --}}
        <div class="form-group row">
            <label for="pro_password" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PASSWORD')</label>

            <div class="col-md-6 col-vcenter">
                <input id="pro_password" name="pro_password" type="password" maxlength="80" class="form-control">
                @if ($errors->has('pro_password'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('pro_password') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Password --}}

        {{-- Password Confirmation --}}
        <div class="form-group row">
            <label for="pro_password_confirmation" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.CONFIRM_PASSWORD')</label>
            <div class="col-md-6 col-vcenter">
                <input id="pro_password_confirmation" name="pro_password_confirmation" type="password" maxlength="80" class="form-control">
            </div>
        </div>
        {{-- Password Confirmation --}}

        {{-- Privacy policy checkbox --}}
        <div class="row">
            <div class="col-md-6 offset-md-4 col-vcenter">
                <div class="custom-control custom-checkbox">
                    <input id="cb_pro_policy" name="cb_pro_policy" type="checkbox" class="custom-control-input">
                    <label for="cb_pro_policy" class="custom-control-label">@lang('pg_registry.CHECKBOX_POLICIES') <a href="{{route('professional policies')}}">@lang('pg_registry.CHECKBOX_POLICIES_PROFESSIONALS')</a>.</label>
                </div>
                @if ($errors->has('cb_pro_policy'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('cb_pro_policy') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Privacy policy checkbox --}}

        {{-- Button --}}
        <div class="form-group row mb-0 mt-3">
            <div class="col-md-6 offset-md-4">
                <button id="btn_submit_new_pro" type="submit" class="btn vbtn-main">
                    @lang('pg_registry.BTN_REGISTER')
                </button>
            </div>
        </div>
        {{-- Button --}}

    </div>
</div>