{{--
    SLOTS:
        id (optional)
        loading_msg (optional) - if none is set, the default message is used
        show (optional) - if not set, the panel will start hidden

--}}

<div @isset($id) id="{{$id}}" @endif class="row my-5 async-panel" @if(!isset($show))style="display: none"@endif>
    <div class="col-12 text-center">
        <div class="vicon-main spinner-border"></div>
    </div>
    <div class="col-12 mt-2 text-center">
        <h5 class="h5">@isset($loading_msg) {!! $loading_msg !!} @else @lang('generic.STANDARD_LOADING_MSG') @endif</h5>
    </div>
</div>