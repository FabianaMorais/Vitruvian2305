{{-- Sidebar

Slots:
    style_class: the css class for the navbar's color theme
    menu: The menu made of sidebar_option components
    user_role: The user's subtitle

 --}}

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endsection

@component('navigation.sidebar.sidebar_top_mobile')
    @slot('style_class')
        {{ $style_class }}
    @endslot
@endcomponent

<div id="nav_sidebar" class="sidebar @if(isset($style_class)) {{ $style_class }} @endif">

    {{-- Menu header + passing links and text --}}
    @component('navigation.sidebar.sidebar_header')
        @if(isset($user_role))
            @slot('user_role')
                {{$user_role}}
            @endslot
        @endif

        @if(isset($header_link))
            @slot('header_link')
                {{$header_link}}
            @endslot
        @endif
    @endcomponent

    {{-- Custom menu made of sidebar_option components --}}
    @if(isset($menu))
        {!! $menu !!}
    @endif

    {{-- Logout button --}}
    @component('navigation.sidebar.sidebar_option')
        @slot('icon')
            <i class="fas fa-sign-out-alt"></i>
        @endslot

        @slot('text')
            @lang('nav_app.LOGOUT')
        @endslot

        @slot('onClick')
            logout();
        @endslot
    @endcomponent

    {{-- Logout form to logout through the navbar --}}
    <form name="form_logout" action="/logout" method="POST" style="display:none">
        @csrf
    </form>

</div>

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/sidebar.js') }}"></script>
@endsection