@extends('profile.profile_base')

@section('profile_view')
<div class="row">
    <div class="col-12 offset-0 px-4
                col-lg-10 offset-lg-1 px-lg-0">
        <div class="row">
            <div class="col-12">
                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_profile.SECTION_ACCOUNT')</h6>
                <hr class="mt-1">
            </div>

            {{-- Username --}}
            <div class="col-12">
                <h6 class="h6 font-weight-light">@lang('pg_profile.USERNAME')</h6>
            </div>

            <div class="col-12">
                <h6 class="h6 text-break">
                    @if(isset($user_data->username))
                        {{ $user_data->username }}
                    @else
                        @lang('pg_profile.EMPTY_FIELD')
                    @endif
                </h6>
            </div>
            {{-- Username --}}

            {{-- Email --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.EMAIL')</h6>
            </div>

            <div class="col-12">
                <h6 class="h6 text-break">
                    @if(isset($user_data->email))
                        {{ $user_data->email }}
                    @else
                        @lang('pg_profile.EMPTY_FIELD')
                    @endif
                </h6>
            </div>
            {{-- Email --}}

            <div class="col-12 mt-5">
                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_profile.ORG_SECTION_OFFICIAL')</h6>
                <hr class="mt-1">
            </div>

            {{-- Full Name --}}
            <div class="col-12">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_FULL_NAME')</h6>
            </div>

            <div class="col-12">
                <h6 class="h6 text-break">
                    @if(isset($user_data->full_name))
                        {{ $user_data->full_name }}
                    @else
                        @lang('pg_profile.EMPTY_FIELD')
                    @endif
                </h6>
            </div>
            {{-- Full Name --}}

            {{-- Leader Name --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_LEADER')</h6>
            </div>

            <div class="col-12">
                <h6 class="h6 text-break">
                    @if(isset($user_data->leader_name))
                        {{ $user_data->leader_name }}
                    @else
                        @lang('pg_profile.EMPTY_FIELD')
                    @endif
                </h6>
            </div>
            {{-- Leader Name --}}


            {{-- Fiscal Number --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_FISCAL')</h6>
            </div>

            <div class="col-12">
                <h6 class="h6 text-break">
                    @if(isset($user_data->fiscal_number))
                        {{ $user_data->fiscal_number }}
                    @else
                        @lang('pg_profile.EMPTY_FIELD')
                    @endif
                </h6>
            </div>
            {{-- Fiscal Number --}}

            {{-- Address --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_ADDRESS')</h6>
            </div>

            <div class="col-12">
                <h6 class="h6 text-break" type="text">
                    @if(isset($user_data->address))
                        {{ $user_data->address }}
                    @else
                        @lang('pg_profile.EMPTY_FIELD')
                    @endif
                </h6>
            </div>
            {{-- Address --}}

            {{-- Phone --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_PHONE')</h6>
            </div>

            <div class="col-12">
                <h6 class="h6 text-break" type="text">
                    @if(isset($user_data->phone))
                        {{ $user_data->phone }}
                    @else
                        @lang('pg_profile.EMPTY_FIELD')
                    @endif
                </h6>
            </div>
            {{-- Phone --}}

        </div>
    </div>
</div>


<div class="row">
    <div class="col-12 offset-0 px-4 mt-4
                col-lg-10 offset-lg-1 px-lg-0">
        <div class="row">
            <div class="col-12 mt-4">
                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_profile.ORG_SECTION_SECURITY')</h6>
                <hr class="mt-1">
            </div>
        </div>
    </div>
</div>
<div class="row">
    {{-- Organizations' code --}}
    <div class="col-12 offset-0 px-4 
                col-md-6 offset-md-0
                col-lg-5 offset-lg-1 px-lg-0 ">

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-auto">
                        <h2><i class="vicon-main fas fa-key"></i></h2>
                    </div>
                    <div class="col">
                        <h6 class="h6 mb-1 font-weight-bold">@lang('organization.ORG_CODE')</h6>
                        <h6 class="h6 font-weight-light">@lang('organization.ORG_CODE_DESCRIPTION')</h6>
                    </div>
                </div>
            </div>

            <div class="card-body p-2 text-center">
                <h4 class="h4 font-weight-bold mt-1">{{ $org_code }}</h4>
            </div>

        </div>
    </div>
    {{-- Organizations' code --}}
</div>

@endsection


@section('profile_edit')
<div class="row">
    <div class="col-12 offset-0 px-4
                col-lg-10 offset-lg-1 px-lg-0">
        <div class="row">
            <div class="col-12 mt-5">
                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_profile.ORG_SECTION_OFFICIAL')</h6>
                <hr class="mt-1">
            </div>

            {{-- Full Name --}}
            <div class="col-12">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_FULL_NAME')</h6>
            </div>

            <div class="col-12">
                <input name="full_name" class="form-control form-control-sm {{ $errors->has('full_name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('pg_profile.ORG_FULL_NAME_PH')"
                    @if(old('full_name') !== null)
                        value="{{ old('full_name') }}"
                    @elseif(isset($user_data->full_name))
                        value="{{ $user_data->full_name }}"
                    @endif
                >

                @if ($errors->has('full_name'))
                    <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('full_name') }}</strong></span>
                @endif
            </div>
            {{-- Full Name --}}


            {{-- Leader Name --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_LEADER')</h6>
            </div>

            <div class="col-12">
                <input name="leader_name" class="form-control form-control-sm {{ $errors->has('leader_name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('pg_profile.ORG_LEADER_PH')"
                    @if(old('leader_name') !== null)
                        value="{{ old('leader_name') }}"
                    @elseif(isset($user_data->leader_name))
                        value="{{ $user_data->leader_name }}"
                    @endif
                >

                @if ($errors->has('leader_name'))
                    <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('leader_name') }}</strong></span>
                @endif
            </div>
            {{-- Leader Name --}}


            {{-- Fiscal Number --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_FISCAL')</h6>
            </div>

            <div class="col-12">
                <input name="fiscal_number" class="form-control form-control-sm {{ $errors->has('fiscal_number') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('pg_profile.ORG_FISCAL_PH')"
                    @if(old('fiscal_number') !== null)
                        value="{{ old('fiscal_number') }}"
                    @elseif(isset($user_data->fiscal_number))
                        value="{{ $user_data->fiscal_number }}"
                    @endif
                >

                @if ($errors->has('fiscal_number'))
                    <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('fiscal_number') }}</strong></span>
                @endif
            </div>
            {{-- Fiscal Number --}}


            {{-- Address --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_ADDRESS')</h6>
            </div>

            <div class="col-12">
                <input name="address" type="text" class="form-control form-control-sm {{ $errors->has('address') ? ' is-invalid' : '' }}" maxlength="160" placeholder="@lang('pg_profile.ORG_ADDRESS_PH')"
                    @if(old('address') !== null)
                        value="{{ old('address') }}"
                    @elseif(isset($user_data->address))
                        value="{{ $user_data->address }}"
                    @endif
                >

                @if ($errors->has('address'))
                    <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('address') }}</strong></span>
                @endif
            </div>
            {{-- Address --}}


            {{-- Phone --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ORG_PHONE')</h6>
            </div>

            <div class="col-12">
                <input name="phone" type="text" class="form-control form-control-sm {{ $errors->has('phone') ? ' is-invalid' : '' }}" maxlength="30" placeholder="@lang('pg_profile.ORG_PHONE_PH')"
                    @if(old('phone') !== null)
                        value="{{ old('phone') }}"
                    @elseif(isset($user_data->phone))
                        value="{{ $user_data->phone }}"
                    @endif
                >

                @if ($errors->has('phone'))
                    <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('phone') }}</strong></span>
                @endif
            </div>
            {{-- Phone --}}

        </div>
    </div>
</div>

@endsection