<div class="sidebar-option py-3"
    @if(isset($header_link)) onClick="window.location.href='{{$header_link}}'" @endif
    >
    <div class="sidebar-opt-ico">

        <img style="width: 70%; height: 70%; margin-left: 15%; margin-right: 15%;" class="rounded-circle" src="{{ asset('user_uploads/avatars/' . session('avatar')) }}">

    </div>
    <div class="sidebar-header-txt row pt-2">
        <div class="col-10">
            <div class="row">
                <div class="col-12 font-weight-bold">
                    {{ Auth::user()->name }}
                </div>

                @if(isset($user_role))
                    <div class="col-12">
                        <p class="font-weight-light font-italic">{{$user_role}}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-2 text-right">
            <h5><i class="fas fa-edit"></i></h5>
        </div>

    </div>
</div>