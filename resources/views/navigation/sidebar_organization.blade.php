@component('navigation.sidebar.sidebar')

    @slot('style_class')
        vstyle-org-nav
    @endslot

    @slot('user_role')
        {{ ucwords( trans('generic.ORGANIZATION') ) }}
    @endslot

    @slot('header_link')
        {{ route('profile') }}
    @endslot

    @slot('menu')

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
            <i class="fas fa-id-badge"></i>
            @endslot

            @slot('text')
                @lang('nav_app.MANAGE_PROS')
            @endslot

            @slot('link')
                {{ route('org.manage.pros') }}
            @endslot

        @endcomponent

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-user-injured"></i>
            @endslot

            @slot('text')
                Manage Patients
            @endslot
        @endcomponent

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-users"></i>
            @endslot

            @slot('text')
                @lang('nav_app.MANAGE_TEAMS')
            @endslot

            @slot('link')
                {{ route('teams.index') }}
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