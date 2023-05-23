@extends('base.page_public')

@section('content')
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="h1 vpg-title">@lang('pgs_public.DONATIONS_TTL')</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-8 px-0 py-4 text-center order-2
                    col-sm-7 p-sm-4
                    col-md-5 offset-md-1 text-md-left order-md-1
                    col-lg-5 offset-lg-0
                    col-xl-4
                    col-vcenter">
            <h2 class="h2 vpg-desc">@lang('pgs_public.DONATIONS_SUBTITLE_1')</h2> 
        </div>
        <div class="col-8 px-0 py-4 order-1
                    col-sm-7 p-sm-4
                    col-md-6 order-md-2
                    col-lg-5
                    col-xl-4
                    text-center">
            <img style="width: 80%; height: auto;" src="{{asset('images/public_pages/donations/donations.svg') }}">
        </div>
    </div>


    <div class="row justify-content-center vstyle-dark">
        <div class="col-8 px-0 py-4
                    col-sm-7 p-sm-4
                    col-md-6
                    col-lg-5
                    col-xl-4
                    text-center">
            <img style="width: 80%; height: auto;" src="{{asset('images/public_pages/donations/first_users.svg') }}"> 
        </div>
        <div class="col-8 px-0 py-4 text-center
                    col-sm-7 p-sm-4
                    col-md-5 text-md-left
                    col-lg-5 
                    col-xl-4
                    col-vcenter">
            <h2 class="h2 vpg-desc vtext-light">@lang('pgs_public.DONATIONS_SUBTITLE_2')</h2> 
        </div>
    </div>



    <div class="row justify-content-center">
        <div class="col-8 px-0 py-4 text-center order-2
                    col-sm-7 p-sm-4
                    col-md-5 offset-md-1 text-md-left order-md-1
                    col-lg-5 offset-lg-0
                    col-xl-4
                    col-vcenter">
            <h2 class="h2 vpg-desc">@lang('pgs_public.DONATIONS_SUBTITLE_3')</h2> 
        </div>
        <div class="col-8 px-0 py-4 order-1
                    col-sm-7 p-sm-4
                    col-md-6 order-md-2
                    col-lg-5
                    col-xl-4
                    text-center">
            <img style="width: 80%; height: auto;" src="{{asset('images/public_pages/donations/investors.svg') }}">
        </div>
    </div>


    <div class="row justify-content-center vstyle-dark">
        <div class="col-8 px-0 py-4
                    col-sm-7 p-sm-4
                    col-md-6
                    col-lg-5
                    col-xl-4
                    text-center col-vcenter">
            <img class="mx-auto" style="width: 80%; height: auto;" src="{{asset('images/public_pages/donations/transfer.svg') }}"> 
        </div>
        <div class="col-8 px-0 py-4 text-center
                    col-sm-7 p-sm-4
                    col-md-5 text-md-left
                    col-lg-5 
                    col-xl-4
                    col-vcenter">

            <div class="row">
                <div class="col-12">
                    <h2 class="h2 mb-4 text-center">@lang('pgs_public.DONATIONS_SUBTITLE_4')</h2>
                </div>
            </div>

            <div class="row">
                <table class="table table-bordered">
                    <tr>
                        <th colspan=3 class="bg-transparent text-white" style="font-weight:600;">@lang('pgs_public.DONATIONS_BANK_INFO_LBL_1') <span style="font-weight:200">@lang('pgs_public.DONATIONS_BANK_INFO_VALUE_1')</span></th>
                    </tr>
                    <tr>
                        <th colspan=3 class="bg-transparent text-white" style="font-weight:600;">@lang('pgs_public.DONATIONS_BANK_INFO_LBL_2') <span style="font-weight:200">@lang('pgs_public.DONATIONS_BANK_INFO_VALUE_2')</span></th>
                    </tr>
                    <tr>
                        <th colspan=3 class="bg-transparent text-white" style="font-weight:600;">@lang('pgs_public.DONATIONS_BANK_INFO_LBL_3') <span style="font-weight:200">@lang('pgs_public.DONATIONS_BANK_INFO_VALUE_3')</span></th>
                    </tr>
                    <tr>
                        <th class="bg-transparent text-white" style="font-weight:600;">@lang('pgs_public.DONATIONS_BANK_INFO_LBL_8')</th>
                        <td class="bg-transparent text-white" colspan=2 >@lang('pgs_public.DONATIONS_BANK_INFO_LBL_5') <span style="font-weight:200">@lang('pgs_public.DONATIONS_BANK_INFO_VALUE_5')</span></td>
                    </tr>
                    <tr>
                        <th class="bg-transparent text-white" tyle="font-weight:600;">@lang('pgs_public.DONATIONS_BANK_INFO_LBL_9')</th>
                        <td class="bg-transparent text-white" colspan=2 >@lang('pgs_public.DONATIONS_BANK_INFO_LBL_5') <span style="font-weight:200">@lang('pgs_public.DONATIONS_BANK_INFO_VALUE_7')</span></td>
                    </tr>
                    <tr>
                        <th colspan=3 class="bg-transparent text-white" style="font-weight:600;">@lang('pgs_public.DONATIONS_BANK_INFO_LBL_6') <span style="font-weight:200">@lang('pgs_public.DONATIONS_BANK_INFO_VALUE_6')</span></th>
                    </tr>
                </table>
            </div>
            <div class="row">
                <div class="col-12">
                    <h6 class="h6 text-center mt-4">@lang('pgs_public.DONATIONS_EXTRA_INFO')</h6>
                </div>
            </div>

        </div>
    </div>

@endsection

