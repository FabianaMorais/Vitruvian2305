@extends('base.page_public')

@section('content')
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title mb-2 mb-sm-5"><span>Login</span></h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12
                    col-lg-8">

            <div class="container py-5 rounded vstyle-light shadow">
                <div class="row justify-content-center" style="min-height:50vh;">

                    {{--login image --}}
                    <div class="col-12 d-none
                                col-md-6 d-md-flex
                                col-vcenter">
                        <img class="mx-auto" src="{{ asset('images/public_pages/login.svg') }}" style="width:90%; height:auto;">
                    </div>

                    {{--login form--}}
                    <div class="col-12 col-vcenter
                                col-sm-10
                                col-md-6
                                col-lg-5">

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row justify-content-center">
                                <label for="email" class="col-10 col-md-8 col-form-label">{{ __('E-Mail Address') }}</label>

                                <div class="col-10 col-md-8">
                                    <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label for="password" class="col-10 col-md-8 col-form-label">{{ __('Password') }}</label>

                                <div class="col-10 col-md-8">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row justify-content-center mb-4">
                                <div class="col-10  text-center">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-10 text-center">
                                    <button type="submit" class="btn vbtn-main">
                                        {{ __('Login') }}
                                    </button>

                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
