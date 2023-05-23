@component('navigation.sidebar.sidebar')

    @slot('style_class')
        vstyle-doc-nav
    @endslot

    @slot('user_role')
        {{ ucwords( trans('generic.DOCTOR') ) }}
    @endslot

    @slot('header_link')
        {{ route('profile') }}
    @endslot

    @slot('menu')

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-hand-holding-heart"></i>
            @endslot

            @slot('text')
                @lang('pg_professionals.LIST_PATIENTS_TTL')
            @endslot

            @slot('link')
                {{ route('list patients') }}
            @endslot
        @endcomponent

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-calendar-check"></i>
            @endslot

            @slot('text')
                Manage Appointments
            @endslot
        @endcomponent

        {{-- Only pros with organization should be able to view this option --}}
        @if( Auth::user()->getRoleData()->hasOrganization() )
        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-users"></i>
            @endslot

            @slot('text')
                @lang('nav_app.VIEW_TEAMS')
            @endslot

            @slot('link')
                {{ route('teams.index') }}
            @endslot

        @endcomponent
        @endif

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-file-export"></i>
            @endslot

            @slot('text')
                @lang('pg_professionals.DOWNLOAD_DATA_TTL')
            @endslot

        @endcomponent

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-project-diagram"></i>
            @endslot

            @slot('text')
                API
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