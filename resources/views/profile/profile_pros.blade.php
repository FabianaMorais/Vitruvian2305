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
                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_profile.PRO_SECTION_PERSONAL')</h6>
                <hr class="mt-1">
            </div>

            {{-- Full Name --}}
            <div class="col-12">
                <h6 class="h6 font-weight-light">@lang('pg_profile.PRO_FULL_NAME')</h6>
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

            {{-- Address --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.PRO_ADDRESS')</h6>
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
                <h6 class="h6 font-weight-light">@lang('pg_profile.PRO_PHONE')</h6>
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
@endsection


@section('profile_edit')
<div class="row">
    <div class="col-12 offset-0 px-4
                col-lg-10 offset-lg-1 px-lg-0">
        <div class="row">
            <div class="col-12 mt-5">
                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_profile.PRO_SECTION_PERSONAL')</h6>
                <hr class="mt-1">
            </div>

            {{-- Full Name --}}
            <div class="col-12">
                <h6 class="h6 font-weight-light">@lang('pg_profile.PRO_FULL_NAME')</h6>
            </div>

            <div class="col-12">
                <input name="full_name" class="form-control form-control-sm {{ $errors->has('full_name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('pg_profile.PRO_FULL_NAME_PH')"
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


            {{-- Address --}}
            <div class="col-12 mt-3">
                <h6 class="h6 font-weight-light">@lang('pg_profile.PRO_ADDRESS')</h6>
            </div>

            <div class="col-12">
                <input name="address" type="text" class="form-control form-control-sm {{ $errors->has('address') ? ' is-invalid' : '' }}" maxlength="160" placeholder="@lang('pg_profile.PRO_ADDRESS_PH')"
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
                <h6 class="h6 font-weight-light">@lang('pg_profile.PRO_PHONE')</h6>
            </div>

            <div class="col-12">
                <input name="phone" type="text" class="form-control form-control-sm {{ $errors->has('phone') ? ' is-invalid' : '' }}" maxlength="30" placeholder="@lang('pg_profile.PRO_PHONE_PH')"
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