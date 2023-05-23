<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> {{-- Enabling responsive bahaviour --}}

        {{-- Social Sharing --}}
        <meta property="og:title" content="Vitruvian Shield">
        <meta property="og:image" content="{{ asset('images/core/logo-social.png') }}">
        <meta property='og:description' content="{{ trans('pg_welcome.APP_SOCIAL_MSG') }}"/>

        {{-- Icon and name --}}
        <link rel="shortcut icon" href="{{ asset('images/core/fav-icon-96x96.ico') }}">
        <title>VitruvianShield®</title>

        {{-- Fonts --}}
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,800,500,600' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Slab&display=swap" rel="stylesheet" type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet"> {{-- Code examples (API docs) --}}

        {{-- CSS --}}
        <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-addons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/vitruvian-app-core.css') }}">
        <link rel="stylesheet" href="{{ asset('css/btn_to_top.css') }}"> {{-- Button back to top --}}
        <link rel="stylesheet" href="{{ asset('css/component_styles.css') }}">
        <link rel="stylesheet" href="{{ asset('css/ldbtn.min.css') }}"> {{-- Animated buttons --}}
        <link rel="stylesheet" href="{{ asset('css/imagehover.css') }}"> {{-- Card animations --}}
        <link rel="stylesheet" href="{{ asset('css/loading.min.css') }}"> {{-- Loading animations --}}

        {{-- Custom CSS --}}
        @hasSection('css')
            @yield('css')
        @endif
    </head>

    <body class="js-focus-visible vstyle-background-light">

        <a id="btn_to_top"><i class="fas fa-angle-up"></i></a> {{-- Back to Top button --}}

        @hasSection('canvas')
            @yield('canvas')
        @endif

        {{-- Javascripts --}}
        <script type="text/javascript" src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/vendor/jquery-validation/dist/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/vendor/bootstrap/bootstrap.min.js') }}"></script>

        <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
        </script>

        <script type="text/javascript" src="{{ asset('js/vitruvian_core.js') }}"></script> {{-- Vitruvian app permanent functions --}}
        <script type="text/javascript" src="{{ asset('js/btn_to_top.js') }}"></script>

        {{-- Recaptcha --}}
        <meta name="grecaptcha-key" content="{{config('recaptcha.v3.public_key')}}">
        <script src="https://www.google.com/recaptcha/api.js?render={{config('recaptcha.v3.public_key')}}" async defer></script>

        @hasSection('js')
            @yield('js')
        @endif
        {{-- Javascripts --}}

    </body>
</html>