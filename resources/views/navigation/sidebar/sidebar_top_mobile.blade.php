<div class="sidebar-mobile-menu d-block d-md-none @if(isset($style_class)) {{ $style_class }} @endif" onClick="toggleSidebar()">
    <div class="row text-center m-1">
        <div class="col-auto col-vcenter p-2">
            <img style="width: 35px; height: 35px; margin-left: auto; margin-right: auto;" class="rounded-circle" src="{{ asset('user_uploads/avatars/' . session('avatar')) }}">
        </div>
        <div class="col-auto col-vcenter p-2">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</div>