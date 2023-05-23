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
                <i class="fas fa-hand-holding-heart"></i>
            @endslot

            @slot('text')
                @lang('pg_professionals.LIST_PATIENTS_TTL')
            @endslot

            @slot('link')
                {{ route('list patients') }}
            @endslot
        @endcomponent

        {{-- Only pros with organization should be able to view this option --}}
        @if( Auth::user()->getRoleData()->hasOrganization() )

            <div class="sidebar-spacer"></div>

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