@extends('base.page_app')

@section('content')

    <form action="{{ route('teams.save') }}" method="POST">
    @csrf

        <div class="row">
            <div class="col-12">
                <h1 class="h1">@lang('pgs_manage_teams.TITLE_NEW')</h1>
            </div>
        </div>

        {{-- Info panel --}}
        <div class="row my-5">
            <div class="col-12 offset-0 col-vcenter mt-3 order-2
                        col-sm-10 offset-sm-1
                        col-md-6 offset-md-0 order-md-1 mt-md-0
                        col-lg-4 offset-lg-2" >

                <div class="row">
                    <div class="col-12">
                        <h3 class="h3">@lang('pgs_manage_teams.EMPTY_MSG_TITLE')</h3>
                        <h6 class="h6 font-weight-light">@lang('pgs_manage_teams.EMPTY_MSG_A')</h6>
                        <h6 class="h6 font-weight-light">@lang('pgs_manage_teams.EMPTY_MSG_B')</h6>
                    </div>

                </div>
            </div>

            <div class="col-12 text-center col-vcenter order-1
                        col-sm-8 offset-sm-2
                        col-md-6 offset-md-0 order-md-2
                        col-lg-4">
                <img class="w-100" src="{{ asset('images/illustrations/manage_teams.png') }}">
            </div>
        </div>
        {{-- Info panel --}}

        <div class="row">

            {{-- Team Name --}}
            <div class="col-12
                        col-sm-10 offset-sm-1
                        col-md-12 offset-md-0
                        col-lg-8 offset-lg-2">
                <h6 class="h6 font-weight-light">@lang('record_team.NAME')</h6>
            </div>

            <div class="col-12
                        col-sm-10 offset-sm-1
                        col-md-12 offset-md-0
                        col-lg-8 offset-lg-2">
                <input name="name" class="form-control form-control-lg {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" maxlength="80" placeholder="@lang('record_team.NAME_PH')"
                    @if(old('name') !== null)
                        value="{{ old('name') }}"
                    @endif
                >

                @if ($errors->has('name'))
                    <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>
            {{-- Team Name --}}

            {{-- Description --}}
            <div class="col-12 mt-3
                        col-sm-10 offset-sm-1
                        col-md-12 offset-md-0
                        col-lg-8 offset-lg-2">
                <h6 class="h6 font-weight-light">@lang('record_team.DESCRIPTION')</h6>
            </div>

            <div class="col-12
                        col-sm-10 offset-sm-1
                        col-md-12 offset-md-0
                        col-lg-8 offset-lg-2">

                <textarea name="description" type="text" class="form-control form-control-sm {{ $errors->has('description') ? ' is-invalid' : '' }}" rows="5" maxlength="800" placeholder="@lang('record_team.DESCRIPTION_PH')">@if(old('description') !== null) {{ old('description') }} @endif</textarea>

                @if ($errors->has('description'))
                    <span class="invalid-feedback d-block text-left ml-1 mt-0 mb-1" role="alert"><strong>{{ $errors->first('description') }}</strong></span>
                @endif
            </div>
            {{-- Description --}}

            <div class="col-12 text-center text-sm-right mt-3
                        col-sm-10 offset-sm-1
                        col-md-12 offset-md-0
                        col-lg-8 offset-lg-2">
                <button type="submit" class="btn btn-sm vbtn-main"><i class="fas fa-user-friends"></i> @lang('pgs_manage_teams.BTN_SAVE_NEW')</button>
            </div>

        </div>


    </form>

@endsection