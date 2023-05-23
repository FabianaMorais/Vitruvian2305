<div class="vstyle-dark row position-relative justify-content-center align-content-end" style="height: 100vh;">

    {{-- NO SLIDES
    <div class="col-12 position-absolute frozen-panel right"
        style="height: 100vh; background-image: url( {{ asset('images/public_pages/welcome_image_1.jpg') }} );">
    </div>
    --}}

    <div  class="col-12 p-0 position-absolute h-100">
        <div id="carouselWelcome" class="carousel slide carousel-fade h-100" data-ride="carousel">

            <ol class="carousel-indicators">
                <li data-target="#carouselWelcome" data-slide-to="0" class="active"></li>
                <li data-target="#carouselWelcome" data-slide-to="1"></li>
                <li data-target="#carouselWelcome" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner h-100">
                <div class="h-100 carousel-item active">
                    <img class="w-100 h-100 frozen-panel center"
                        style="background-image: url( {{ asset('images/public_pages/welcome_image_1.jpg') }} );">
                </div>
                <div class="h-100 carousel-item">
                    <img class="w-100 h-100 frozen-panel"
                        style="background-image: url( {{ asset('images/public_pages/welcome_image_2.jpg') }} );">
                </div>
                <div class="h-100 carousel-item">
                    <img class="w-100 h-100 frozen-panel left"
                        style="background-image: url( {{ asset('images/public_pages/welcome_image_3.jpg') }} );">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-center pb-5 mb-5" style="z-index: 3;">
        <h1 class="h1 mb-2 vpg-title vtext-light" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.5);">@lang('pgs_public.WELCOME_TITLE')</h1>
        <h4 class="h4 vtext-light mb-3" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.5);">@lang('pgs_public.WELCOME_MSG')</h4>
        <a href="{{ route('register') }}" class="btn vbtn-clear vbtn-large">@lang('pgs_public.GET_STARTED')</a>
    </div>

</div>