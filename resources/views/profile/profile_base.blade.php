@extends('base.page_app')

@section('content')

<div class="vstyle-main rounded-top shadow " style="height: 170px; width: 100%; position: absolute; left: 0px; top: 0px;"></div>


<div class="row position-relative">

    <div class="col-12 text-center" style="margin-top: 60px">
        <img id='img_avatar' class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . session('avatar')) }}" alt="user image">
        <h2 class="h2">{{ Auth::user()->name }}</h2>

        @if(isset($user_data))
            <h6 class="h6 font-weight-light font-italic">{{ $user_data->role }}</h6>
        @endif

    </div>

    <div class="col-12 mt-2">
        <nav>{{-- If there are any form errors, we show the edit tab --}}
            <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                <a class="nav-link @if(!isset($errors) || count($errors) == 0) active @endif" id="nav-view-tab" data-toggle="tab" href="#nav-view" role="tab" aria-controls="nav-view" aria-selected="@if(!isset($errors) || count($errors) == 0) true @else false @endif">
                    <i class="fas fa-eye"></i>
                </a>
                <a class="nav-link @if(isset($errors) && count($errors) > 0) active @endif" id="nav-edit-tab" data-toggle="tab" href="#nav-edit" role="tab" aria-controls="nav-edit" aria-selected="@if(isset($errors) && count($errors) > 0) false @else true @endif">
                    <i class="fas fa-edit"></i>
                </a>
                <a class="nav-link" id="nav-config-tab" data-toggle="tab" href="#nav-config" role="tab" aria-controls="nav-config" aria-selected="false">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </nav>
    </div>

</div>


<div class="row">
    <div class="col-12">

        <div class="tab-content" id="nav-tabContent">{{-- If there are any form errors, we show the edit tab --}}
            @hasSection('profile_view')
            <div id="nav-view" class="tab-pane fade pt-4 @if(!isset($errors) || count($errors) == 0) show active @endif" role="tabpanel" aria-labelledby="nav-view-tab">
                @yield('profile_view')
            </div>
            @endif
            <div id="nav-edit" class="tab-pane fade pt-4 @if(isset($errors) && count($errors) > 0) show active @endif" role="tabpanel" aria-labelledby="nav-edit-tab">

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                    @include('profile.shared_components.avatar_picker')

                    @hasSection('profile_edit')
                        @yield('profile_edit')
                    @endif

                    <div class="row mt-4">
                        <div class="col-12 offset-0 px-4 text-center
                                    col-lg-10 offset-lg-1 px-lg-0 text-md-right">
                            <button type="submit" class="btn btn-sm vbtn-main"><i class="fas fa-save"></i> @lang('pg_profile.APPLY')</button>
                        </div>
                    </div>
                </form>

            </div>

            <div id="nav-config" class="tab-pane fade pt-4" role="tabpanel" aria-labelledby="nav-config-tab">

                <div class="row">
                    <div class="col-12 offset-0 px-4 pb-4
                                col-md-6 offset-md-0 pb-md-0
                                col-lg-5 offset-lg-1">
                        @include('profile.shared_components.password_changer')
                    </div>
                    <div class="col-12 offset-0 px-4 pb-4
                                col-md-6 offset-md-0 pb-md-0
                                col-lg-5">
                        @include('profile.shared_components.delete_account')
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/image_selector.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/form_validations.js') }}"></script>
@endsection