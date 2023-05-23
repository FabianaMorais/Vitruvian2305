@extends('base.page_app')

@section('content')
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
                <h4 class="h4 vpg-desc mb-3">@lang('auth.VERIFY_EMAIL')</h4>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                </form>
        </div>
    </div>
@endsection
