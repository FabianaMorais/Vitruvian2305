@extends('base.base')

{{-- Base Canvas sets up navigation (menus, topbars, ...) according to the user type --}}
@section('canvas')

    @if ( Auth::user() != null && isset(Auth::user()->type) )

        <div class="sidebar-canvas">
            <nav class="sidebar-area">

                {{-- Menu depends on user type --}}
                @switch(Auth::user()->type)

                    @case(App\Models\Users\User::ADMIN)
                        @include('navigation.sidebar_admin')
                        @break

                    @case(App\Models\Users\User::RESEARCHER)
                    @include('navigation.sidebar_researcher')
                        @break

                    @case(App\Models\Users\User::DOCTOR)
                        @include('navigation.sidebar_doctor')
                        @break

                    @case(App\Models\Users\User::CAREGIVER)
                        @include('navigation.sidebar_caregiver')
                        @break

                    @case(App\Models\Users\User::ORGANIZATION)
                        @include('navigation.sidebar_organization')
                        @break

                    @case(App\Models\Users\NewUser::NEW_RESEARCHER)
                        @include('navigation.sidebar_new_researcher')
                        @break

                    @case(App\Models\Users\NewUser::NEW_DOCTOR)
                        @include('navigation.sidebar_new_doctor')
                        @break

                    @case(App\Models\Users\NewUser::NEW_CAREGIVER)
                        @include('navigation.sidebar_new_caregiver')
                        @break

                    @case(App\Models\Users\NewUser::NEW_ORGANIZATION)
                        @include('navigation.sidebar_new_organization')
                        @break

                @endswitch

            </nav>

            <div class="content-area">

                <div class="container-fluid" style="min-height: 100vh">
                    @hasSection('page')
                        @yield('page')
                    @endif
                </div>

                @include('navigation.footer_professional')

            </div>
        </div>

    @else {{-- If it is a guest, we show the basic navigation topbar --}}
        @include('navigation.topbar_guest')

        <div class="container-fluid" style="min-height: 100vh">
            @hasSection('page')
                @yield('page')
            @endif
        </div>

        @include('navigation.footer_guest')

        @section('js')
            @parent
            <script type="text/javascript" src="{{ asset('js/nav_guest.js') }}"></script>
        @endsection

    @endif

@endsection