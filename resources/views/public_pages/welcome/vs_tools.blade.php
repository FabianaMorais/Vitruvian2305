{{-- watch component --}}
<div class="row justify-content-center vstyle-dark">
    <div class="col-12 text-center order-2 py-5 
                col-sm-10
                col-md-8
                col-lg-4 text-lg-left order-lg-1
                col-vcenter">
        <h2 class="h2 vpg-subtitle vtext-light">@lang('pgs_public.WELCOME_WATCH_TITLE')</h2>
        <h4 class="h4 mb-2 vpg-desc vtext-light">@lang('pgs_public.WELCOME_WATCH_DESC')</h4>
        <h6 class="h6 mb-3 vtext-light">@lang('pgs_public.WELCOME_WATCH_BY')</h6>
        <a href="{{ route('watch') }}" class="btn vbtn-pop vbtn-large mx-auto ml-lg-0">@lang('pgs_public.KNOW_MORE_BUTTON')</a>
    </div>
    <div class="col-12 order-1
                col-sm-10
                col-md-8
                col-lg-3 order-lg-2
                text-center">
        <img style="width: auto; height: 360px;" src="{{ asset('images/public_pages/watch.png') }}"> 
    </div>
</div>
{{-- watch component --}}


{{-- mobile app component --}}
<div class="row py-5 justify-content-center">
    <div class="col-12
                col-sm-10
                col-md-8
                col-lg-3
                text-center">
        <img style="width: auto; height: 300px;" src="{{ asset('images/public_pages/app.png') }}"> 
    </div>
    <div class="col-12 text-center pt-5
                col-sm-10
                col-md-8
                col-lg-4 text-lg-left pt-lg-0
                col-vcenter">
        <h2 class="h2 vpg-subtitle">@lang('pgs_public.WELCOME_MOBILE_APP_TITLE')</h2>
        <h4 class="h4 vpg-desc mb-3">@lang('pgs_public.WELCOME_MOBILE_APP_DESC')</h4>
        <a href="{{ route('mobile app') }}" class="btn vbtn-main vbtn-large mx-auto ml-lg-0">@lang('pgs_public.KNOW_MORE_BUTTON')</a>
    </div>
</div>
{{-- mobile app component --}}


{{-- web app component --}}
<div class="row py-5 justify-content-center vstyle-dark">
    <div class="col-12 text-center order-2 
                col-sm-10
                col-md-8
                col-lg-4 text-lg-left order-lg-1
                col-vcenter">
        <h2 class="h2 vpg-subtitle vtext-light">@lang('pgs_public.WELCOME_WEB_APP_TITLE')</h2>
        <h4 class="h4 mb-3 vpg-desc vtext-light">@lang('pgs_public.WELCOME_WEB_APP_DESC')</h4>
        <a href="{{ route('register') }}" class="btn vbtn-pop vbtn-large mx-auto ml-lg-0">@lang('pgs_public.GET_STARTED')</a>
    </div>
    <div class="col-10 mb-5 order-1
                col-sm-6
                col-md-5
                col-lg-4 py-lg-5 mb-lg-0 order-lg-2
                col-xl-3
                text-center">
        <img style="width: auto; max-width: 100%; height: auto; max-height: 300px;" src="{{ asset('images/public_pages/web_app_main_page.png') }}"> 
    </div>
</div>
{{-- web app component --}}


{{-- Research API component --}}
<div class="row py-5 justify-content-center">
    <div class="col-10
                col-sm-6
                col-md-6
                col-lg-5
                col-xl-4
                text-center px-5 col-vcenter pt-3">
        <img class="shadow mx-auto" style="width: auto; max-width: 100%; height: auto;" src="{{ asset('images/public_pages/api.png') }}"> 
    </div>
    <div class="col-12 text-center pt-5
                col-sm-10
                col-md-8
                col-lg-4 text-lg-left pt-lg-0
                col-vcenter">
        <h2 class="h2 vpg-subtitle">@lang('pgs_public.WELCOME_RESEARCH_API_TITLE')</h2>
        <h4 class="h4 mb-3 vpg-desc">@lang('pgs_public.WELCOME_RESEARCH_API_DESC')</h4>
        <a href="{{ route('public_api.docs') }}" class="btn vbtn-main vbtn-large mx-auto ml-lg-0">@lang('pgs_public.KNOW_MORE_BUTTON')</a>
    </div>
</div>
{{-- Research API component --}}