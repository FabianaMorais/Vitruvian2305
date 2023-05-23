<nav id="nav_topbar_guest" class="navbar navbar-expand-md navbar-dark fixed-top vstyle-nav" style="min-height: 6vh;" >
    <a class="navbar-brand" href="{{ route('welcome') }}">
        <img style="height: 6vh" src="{{ asset('images/core/main-logo-96x96.png') }}">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navGuestMarkup" aria-controls="navGuestMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navGuestMarkup" class="collapse navbar-collapse">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="{{ route('welcome') }}">@lang('nav_public.WELCOME_LINK')</a>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('nav_public.ABOUT_US')
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('our path') }}">@lang('nav_public.PATH_LINK')</a>
                    <a class="dropdown-item" href="{{ route('team') }}">@lang('nav_public.TEAM_LINK')</a>
                    <a class="dropdown-item" href="{{ route('partners') }}">@lang('nav_public.PARTNERS_LINK')</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('become partner') }}">@lang('nav_public.BECOME_PARTNER_LINK')</a>
                    <a class="dropdown-item" href="{{ route('donations') }}">@lang('nav_public.DONATIONS_LINK')</a>
                    <a class="dropdown-item" href="{{ route('contact us') }}">@lang('nav_public.CONTACT_US_LINK')</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('nav_public.VIT_SHIELD')
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('pitch.patients') }}">@lang('nav_public.FOR_INDIVIDUALS')</a>
                    <a class="dropdown-item" href="{{ route('pitch.pros') }}">@lang('nav_public.FOR_PROFESSIONALS')</a>
                    <a class="dropdown-item" href="{{ route('pitch.researchers') }}">@lang('nav_public.FOR_RESEARCHERS')</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('problem') }}">@lang('nav_public.PROBLEM_LINK')</a>
                    <a class="dropdown-item" href="{{ route('concept') }}">@lang('nav_public.CONCEPT_LINK')</a>
                    <a class="dropdown-item" href="{{ route('watch') }}">@lang('nav_public.WATCH_LINK')</a>
                    <a class="dropdown-item" href="{{ route('mobile app') }}">@lang('nav_public.APP_LINK')</a>
                    <a class="dropdown-item" href="{{ route('research api') }}">@lang('nav_public.RESEARCH_API_LINK')</a>
                    <a class="dropdown-item" href="{{ route('data') }}">@lang('nav_public.DATA_LINK')</a>
                    <a class="dropdown-item" href="{{ route('certifications') }}">@lang('nav_public.CERTIFICATIONS_LINK')</a>
                </div>
            </li>
            <a class="nav-item nav-link" href="{{ route('public_api.docs') }}">@lang('nav_public.API_DOCS')</a>
            <a class="nav-item nav-link" href="{{ route('register') }}">@lang('nav_public.REGISTER_LINK')</a>
            <a class="nav-item nav-link" href="{{ route('login') }}">@lang('nav_public.LOGIN_LINK')</a>
        </div>
    </div>
</nav>