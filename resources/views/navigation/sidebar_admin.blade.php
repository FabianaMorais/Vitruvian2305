@component('navigation.sidebar.sidebar')

    @slot('style_class')
        vstyle-admin-nav
    @endslot

    @slot('user_role')
        {{ ucwords( trans('generic.ADMINISTRATOR') ) }}
    @endslot

    @slot('header_link')
        {{ route('profile') }}
    @endslot

    @slot('menu')

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-home"></i>
            @endslot

            @slot('text')
                @lang('nav_app.DASHBOARD')
            @endslot

            @slot('link')
                {{ route('home') }}
            @endslot

        @endcomponent

        @component('navigation.sidebar.sidebar_option')
            @slot('icon')
                <i class="fas fa-user-md"></i>
            @endslot

            @slot('text')
                @lang('pg_manage_regs.TITLE')
            @endslot

            @slot('link')
                {{ route('admin.registrations') }}
            @endslot

        @endcomponent

        <div class="sidebar-spacer"></div>

    @endslot

@endcomponent