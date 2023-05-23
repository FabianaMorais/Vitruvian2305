@component('navigation.sidebar.sidebar')

    @slot('style_class')
        vstyle-care-nav
    @endslot

    @slot('user_role')
        {{ ucwords( trans('generic.CAREGIVER') ) }}
    @endslot

    @slot('header_link')
        {{ route('profile') }}
    @endslot

    @slot('menu')

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-door-open"></i>
            @endslot

            @slot('text')
                @lang('nav_app.WELCOME')
            @endslot

            @slot('link')
                {{ route('home') }}
            @endslot

        @endcomponent

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-hand-holding-heart"></i>
            @endslot

            @slot('text')
                @lang('pg_professionals.LIST_PATIENTS_TTL')
            @endslot

        @endcomponent

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-users"></i>
            @endslot

            @slot('text')
                @lang('nav_app.VIEW_TEAMS')
            @endslot

        @endcomponent

        <div class="sidebar-spacer"></div>

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-comments"></i>
            @endslot

            @slot('text')
                @lang('nav_app.SEND_FEEDBACK')
            @endslot

            @slot('link')
                {{ route('beta.feedback') }}
            @endslot

        @endcomponent

    @endslot

@endcomponent