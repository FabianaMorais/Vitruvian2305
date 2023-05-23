{{--
    SLOTS:
        id (optional)
        empty_msg (optional) - if none is set, the default message is used
        show (optional) - if not set, the panel will start hidden

--}}

<div @isset($id) id="{{$id}}" @endif class="row my-5 async-panel" @if(!isset($show))style="display: none"@endif>
    <div class="col-12 text-center">
        <i class="vicon-main far fa-folder-open" style="width: 40px; height: 40px; font-size:3em;"></i>
    </div>
    <div class="col-12 mt-2 text-center">
        <h5 class="h5">@isset($empty_msg) {!! $empty_msg !!} @else @lang('generic.STANDARD_EMPTY_MSG') @endif</h5>
    </div>
</div>