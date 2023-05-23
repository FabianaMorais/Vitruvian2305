<div class="card">
    <div class="card-body">
        <form action="{{route('patients.new.submit')}}" method="POST">
        @csrf

            <div class="row">

                {{-- Full Name --}}
                <div class="col-12">
                    <h6 class="h6 font-weight-light">@lang('pg_patient_description.FULL_NAME')</h6>
                </div>
                <div class="col-12">
                    <input name="full_name" class="form-control form-control-lg {{ $errors->has('full_name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('pg_patient_description.FULL_NAME_PH')"
                        @if(old('full_name') !== null)
                            value="{{ old('full_name') }}"
                        @endif
                    >

                    @if ($errors->has('full_name'))
                        <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('full_name') }}</strong></span>
                    @endif
                </div>
                {{-- Full Name --}}


                {{-- Username --}}
                <div class="col-12 mt-3">
                    <h6 class="h6 font-weight-light">@lang('pg_patient_description.USERNAME')</h6>
                </div>
                <div class="col-12">
                    <input name="name" value="{{ old('name') }}" class="form-control form-control-sm {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('pg_patient_description.USERNAME_PH')"
                        @if(old('name') !== null)
                            value="{{ old('name') }}"
                        @endif
                    >

                    @if ($errors->has('name'))
                        <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                    @endif
                </div>
                {{-- Username --}}


                {{-- Email --}}
                <div class="col-12 mt-3">
                    <h6 class="h6 font-weight-light">@lang('pg_patient_description.EMAIL')</h6>
                </div>
                <div class="col-12">
                    <input name="email" type="email" class="form-control form-control-sm {{ $errors->has('email') ? ' is-invalid' : '' }}" maxlength="80" placeholder="@lang('pg_patient_description.EMAIL_PH')"
                        @if(old('email') !== null)
                            value="{{ old('email') }}"
                        @endif
                    >

                    @if ($errors->has('email'))
                        <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                </div>
                {{-- Email --}}

                {{-- Phone --}}
                <div class="col-12 mt-3">
                    <h6 class="h6 font-weight-light">@lang('pg_patient_description.PHONE')</h6>
                </div>

                <div class="col-12">
                    <input name="phone" type="text" class="form-control form-control-sm {{ $errors->has('phone') ? ' is-invalid' : '' }}" maxlength="30" placeholder="@lang('pg_patient_description.PHONE_PH')"
                        @if(old('phone') !== null)
                            value="{{ old('phone') }}"
                        @endif
                    >

                    @if ($errors->has('phone'))
                        <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('phone') }}</strong></span>
                    @endif
                </div>
                {{-- Phone --}}
            </div>

            <div class="alert vstyle-support mt-4" role="alert">
                <div class="row">
                    <div class="col-auto text-center col-vcenter">
                        <h2 class=" h2 m-0"><i class="fas fa-exclamation"></i></h2>
                    </div>
                    <div class="col col-vcenter pl-1">
                        @lang('pg_patient_description.INFO_DATA')
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <button type="submit" class="btn vbtn-main">{{ ucfirst( trans('generic.ADD') ) }}</button>
                </div>
            </div>

        </form>

    </div>
</div>