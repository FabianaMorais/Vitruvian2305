<div class="card border-0">
    <div class="card-header vstyle-org">@lang('pg_registry.ORGANIZATION_REGIST_TITLE')</div>

    <div class="card-body vstyle-light">

        <div class="alert alert-light mx-1 mx-lg-5" role="alert">
            <label id="regist_descript_pro_res" class="card-text">
                @lang('pg_registry.ORGANIZATION_DESCRIPT')
            </label>
        </div>

        {{-- Username --}}
        <div class="form-group row">
            <label for="org_name" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.ORGANIZATION_USERNAME')</label>
            <div class="col-md-6 col-vcenter">
                <input id="org_name" name="org_name" type="text" maxlength="80" class="form-control" value="{{ old('org_name') }}">
                @if ($errors->has('org_name'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('org_name') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Username --}}

        {{-- Organization Name --}}
        <div class="form-group row">
            <label for="org_full_name" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.ORGANIZATION_NAME')</label>
            <div class="col-md-6 col-vcenter">
                <input id="org_full_name" name="org_full_name" type="text" maxlength="80" class="form-control" value="{{ old('org_full_name') }}">
                @if ($errors->has('org_full_name'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('org_full_name') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Organization Name --}}

        {{-- Organization Email --}}
        <div class="form-group row">
            <label for="org_email" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.ORGANIZATION_EMAIL')</label>
            <div class="col-md-6 col-vcenter">
                <input id="org_email" name="org_email" type="email" maxlength="80" class="form-control" value="{{ old('org_email') }}">
                @if ($errors->has('org_email'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('org_email') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Organization Email --}}

        {{-- Organization Leader Name --}}
        <div class="form-group row">
            <label for="org_leader_name" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.ORGANIZATION_CEO_NAME')</label>
            <div class="col-md-6 col-vcenter">
                <input id="org_leader_name" name="org_leader_name" type="text" maxlength="80" class="form-control" value="{{ old('org_leader_name') }}">
                @if ($errors->has('org_leader_name'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('org_leader_name') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Organization Leader Name --}}

        {{-- Organization Fiscal Number --}}
        <div class="form-group row">
            <label for="org_fiscal" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.ORGANIZATION_FISCAL')</label>
            <div class="col-md-6 col-vcenter">
                <input id="org_fiscal" name="org_fiscal" type="text" maxlength="80" class="form-control" value="{{ old('org_fiscal') }}">
                @if ($errors->has('org_fiscal'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('org_fiscal') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Organization Fiscal Number --}}

        {{-- Address --}}
        <div class="form-group row">
            <label for="org_address" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.ORGANIZATION_ADDRESS')</label>
            <div class="col-md-6 col-vcenter">
                <input id="org_address" name="org_address" type="address" maxlength="160" class="form-control" value="{{ old('org_address') }}">
                @if ($errors->has('org_address'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('org_address') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Address --}}

        {{-- Phone --}}
        <div class="form-group row">
            <label for="org_phone" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.ORGANIZATION_PHONE')</label>
            <div class="col-md-6 col-vcenter">
                <input id="org_phone" name="org_phone" type="phone" maxlength="30" class="form-control" value="{{ old('org_phone') }}">
                @if ($errors->has('org_phone'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('org_phone') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Phone --}}

        {{-- Password --}}
        <div class="form-group row">
            <label for="org_password" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.PASSWORD')</label>

            <div class="col-md-6 col-vcenter">
                <input id="org_password" name="org_password" type="password" maxlength="80" class="form-control">
                @if ($errors->has('org_password'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('org_password') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Password --}}

        {{-- Password Confirmation --}}
        <div class="form-group row">
            <label for="org_password_confirmation" class="col-md-4 col-form-label text-md-right">@lang('pg_registry.CONFIRM_PASSWORD')</label>
            <div class="col-md-6 col-vcenter">
                <input id="org_password_confirmation" name="org_password_confirmation" type="password" maxlength="80" class="form-control">
            </div>
        </div>
        {{-- Password Confirmation --}}

        {{-- Privacy policy checkbox --}}
        <div class="row">
            <div class="col-md-6 offset-md-4 col-vcenter">
                <div class="custom-control custom-checkbox">
                    <input id="cb_org_policy" name="cb_org_policy" type="checkbox" class="custom-control-input">
                    <label for="cb_org_policy" class="custom-control-label">@lang('pg_registry.CHECKBOX_POLICIES') <a href="{{route('organization policies')}}">@lang('pg_registry.CHECKBOX_POLICIES_ORGANIZATIONS')</a>.</label>
                </div>
                @if ($errors->has('cb_org_policy'))
                    <span class="invalid-feedback d-block text-left" role="alert"><strong>{{ $errors->first('cb_org_policy') }}</strong></span>
                @endif
            </div>
        </div>
        {{-- Privacy policy checkbox --}}

        {{-- Button --}}
        <div class="form-group row mb-0 mt-3">
            <div class="col-md-6 offset-md-4">
                <button id="btn_submit_new_org" type="submit" class="btn vbtn-main">
                    @lang('pg_registry.BTN_REGISTER')
                </button>
            </div>
        </div>
        {{-- Button --}}

    </div>
</div>