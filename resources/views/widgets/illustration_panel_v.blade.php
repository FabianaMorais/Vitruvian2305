{{--
    params
        id -> optional
        title -> mandatory
        desc_1 -> mandatory
        desc_2-> optional
        btns -> optional
        illustration -> mandatory
--}}

<div @if(isset($id)) id="{{$id}}" @endif class="row my-5">
    <div class="col-12
                col-sm-8 offset-sm-2
                text-center col-vcenter">
        <img class="w-100 mx-auto" style="max-width: 300px;" src="{{ asset('images/illustrations/'. $illustration ) }}">
    </div>

    <div class="col-10 offset-1 col-vcenter mt-3">

        <div class="row">
            <div class="col-12">
                <h3 class="h3 vpg-desc">{{ $title }}</h3>
                <h6 class="h6 font-weight-light">{{ $desc_1 }}</h6>
                @if(isset($desc_2))
                    <h6 class="h6 font-weight-light">{{ $desc_2 }}</h6>
                @endif
            </div>

            @if(isset($btns))
            <div class="col-12 text-center
                        text-md-right">
                {!! $btns !!}
            </div>
            @endif

        </div>
    </div>

</div>