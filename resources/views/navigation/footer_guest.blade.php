<footer class="page-footer font-small pt-1 vstyle-footer">

    <div class="container-fluid text-center text-md-left">
        <div class="row mt-3">

            {{-- MESSAGE --}}
            <div class="col-12 mt-3 
                        col-sm-6 col-md-4
                        col-lg-2 mt-md-0">
                <label class="h5 text-uppercase">@lang('nav_public.FOOTER_TITLE')</label>
               

                <ul class="list-unstyled mt-2">
                    <li><a class="vtxt-link" href="{{ route('public_api.docs') }}">@lang('nav_public.API_DOCS')</a></li>
                    <li><a class="vtxt-link" href="{{ route('pitch.patients') }}">@lang('nav_public.FOR_INDIVIDUALS')</a></li>
                    <li><a class="vtxt-link" href="{{ route('pitch.pros') }}">@lang('nav_public.FOR_PROFESSIONALS')</a></li>
                    <li><a class="vtxt-link" href="{{ route('pitch.researchers') }}">@lang('nav_public.FOR_RESEARCHERS')</a></li>
                </ul>
            </div>
            {{-- MESSAGE --}}

            {{-- DIVIDER ON MOBILE ONLY --}}
            <hr class="clearfix w-100 d-md-none pb-3 my-0">

            {{-- VITRUVIAN SHIELD --}}
            <div class="col-12 mb-3
                        col-sm-6 col-md-4
                        col-lg-2 mb-md-0">

                <label class="h5 text-uppercase">@lang('nav_public.OUR_SOLUTION')</label>

                <ul class="list-unstyled">
                    <li><a class="vtxt-link" href="{{ route('problem') }}">@lang('nav_public.PROBLEM_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('concept') }}">@lang('nav_public.CONCEPT_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('watch') }}">@lang('nav_public.WATCH_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('mobile app') }}">@lang('nav_public.APP_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('research api') }}">@lang('nav_public.RESEARCH_API_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('data') }}">@lang('nav_public.DATA_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('certifications') }}">@lang('nav_public.CERTIFICATIONS_LINK')</a></li>
                </ul>
            </div>
            {{-- VITRUVIAN SHIELD --}}

            {{-- ABOUT US --}}
            <div class="col-12 mb-3
                        col-sm-6 col-md-4
                        col-lg-2 mb-md-0">

                <label class="h5 text-uppercase">@lang('nav_public.ABOUT_US')</label>

                <ul class="list-unstyled">
                    <li><a class="vtxt-link" href="{{ route('our path') }}">@lang('nav_public.PATH_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('team') }}">@lang('nav_public.TEAM_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('partners') }}">@lang('nav_public.PARTNERS_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('become partner') }}">@lang('nav_public.BECOME_PARTNER_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('donations') }}">@lang('nav_public.DONATIONS_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('contact us') }}">@lang('nav_public.CONTACT_US_LINK')</a></li>
                </ul>
            </div>
            {{-- ABOUT US --}}

            {{-- OFFICES --}}
            <div class="col-12 mb-3
                        col-sm-6 col-md-12
                        col-lg-6 mb-md-0">

                <label class="h5 text-uppercase">@lang('nav_public.OUR_OFFICES')</label>
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <ul class="list-unstyled">
                            <p>Switzerland<p>
                            <li>Vitruvian Shield SA</li>
                            <li>Rue de la Corniche n°3a</li>
                            <li>Bâtiment Phenyl</li>
                            <p>1066 Epalinges</p>

                            <p>Portugal<p>
                            <li>Vitruvian Shield - PT</li>
                            <li>PCI – Creative Science Park</li>
                            <li>Via do Conhecimento, Edf. Central</li>
                            <p>3830-352 Ílhavo</p>
                            
                        </ul>
                    </div>
                    <div class="col-sm-8 col-md-8 vertical-align">
                        <p class="text-center"><iframe width="310" height="205"
                            src="https://www.youtube.com/embed/YOpXuRqvpVU">
                        </iframe><p>
                    </div>
                </div>
                
            </div>
            {{-- OFFICES --}}


            {{-- POLICIES --}}
           {{-- <div class="col-12 mb-3
                        col-sm-6
                        col-md-3 mb-md-0">

                <h5 class="text-uppercase">@lang('nav_public.POLICIES')</h5>

                <ul class="list-unstyled">
                    <li><a class="vtxt-link" href="{{ route('patient policies') }}">@lang('nav_public.POLICY_PATIENTS_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('professional policies') }}">@lang('nav_public.POLICY_PROFESSIONALS_LINK')</a></li>
                    <li><a class="vtxt-link" href="{{ route('organization policies') }}">@lang('nav_public.POLICY_ORGANIZATIONS_LINK')</a></li>
                </ul>
            </div> --}}
            {{-- POLICIES --}}

        </div>
    </div>

    {{-- COPYRIGHT --}}
    <div class="footer-copyright text-center py-3">@lang('nav_public.COPYRIGHT')
        <a class="vtxt-link" href="{{ route('welcome') }}"> @lang('nav_public.OFFICIAL_NAME')</a>
    </div>
    {{-- COPYRIGHT --}}

</footer>
