@extends('base.page_public')

@section('content')
    {{--contact form --}}

    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.CONTACT_US')</h1>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">

            <div class="container py-5 rounded vstyle-light shadow">

                @if(!isset($form_submitted))
                    <div class="row justify-content-center" >
                        <div class="col-6 d-none d-lg-flex col-vcenter">
                            <img class="mx-auto" src="{{ asset('images/public_pages/contact_us.svg') }}" style="width:90%; height:auto;">
                        </div>
                        <div class="col-12
                                    col-sm-12
                                    col-md-10
                                    col-lg px-xl-5
                                    col-xl">
                            @include('widgets.contact_form')
                        </div>
                    </div>
                @endif

                {{-- form sent successfully message --}}
                @if(isset($form_submitted))
                    @component('widgets.panel_success')
                        @slot('id') contact_form_success_panel @endslot
                        @slot('success_msg') @lang('pg_welcome.FORM_SUBMIT_SUCCESS') @endslot
                        @slot('visible') true @endslot
                    @endcomponent
                @endif

            </div>

        </div>
    </div>
@endsection

