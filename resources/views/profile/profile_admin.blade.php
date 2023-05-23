@extends('profile.profile_base')

@section('profile_view')
{{-- Full Name --}}
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
                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_profile.ADMIN_SECTION_PERSONAL')</h6>
                <hr class="mt-1">
            </div>

            {{-- Full Name --}}
            <div class="col-12">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ADMIN_FULL_NAME')</h6>
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
                <h6 class="h6 text-uppercase font-weight-bold mb-0">@lang('pg_profile.ADMIN_SECTION_PERSONAL')</h6>
                <hr class="mt-1">
            </div>

            {{-- Full Name --}}
            <div class="col-12">
                <h6 class="h6 font-weight-light">@lang('pg_profile.ADMIN_FULL_NAME')</h6>
            </div>

            <div class="col-12">
                <input name="full_name" class="form-control form-control-sm {{ $errors->has('full_name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('pg_profile.ADMIN_FULL_NAME_PH')"
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

        </div>
    </div>
</div>
@endsection