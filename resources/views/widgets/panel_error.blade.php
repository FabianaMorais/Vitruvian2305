{{--
    SLOTS:
        id (optional)
        error_msg (optional) - if none is set, the default message is used
        show (optional) - if not set, the panel will start hidden

--}}

<div @isset($id) id="{{$id}}" @endif class="row my-5 async-panel" @if(!isset($show))style="display: none"@endif>
    <div class="col-12 text-center">
        <i class="vicon-main fas fa-exclamation-triangle" style="width: 40px; height: 40px; font-size:3em;"></i>
    </div>
    <div class="col-12 mt-2 text-center">
        <h5 class="h5">@isset($error_msg) {!! $error_msg !!} @else @lang('generic.STANDARD_ERROR_MSG') @endif</h5>
    </div>
</div>