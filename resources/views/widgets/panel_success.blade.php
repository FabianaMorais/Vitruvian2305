{{--
    SLOTS:
        id (optional)
        success_msg (optional) - if none is set, the default message is used
        visible (optional) - if set, panel is displayed
--}}

<div @isset($id) id="{{$id}}" @endif class="row my-5 async-panel" @if(!isset($visible)) style="display: none" @endif>
    <div class="col-12 text-center">
        <i class="vicon-main far fa-check-circle" style="width: 40px; height: 40px; font-size:3em;"></i>
    </div>
    <div class="col-12 mt-2 text-center">
        <h5 class="h5">@isset($success_msg) {!! $success_msg !!} @else @lang('generic.STANDARD_SUCCESS_MSG') @endif</h5>
    </div>
</div>