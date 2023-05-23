{{--
    params
        id -> optional
        title -> mandatory
        title_id -> optional
        desc_1 -> mandatory
        desc_1_id-> optional (id for desc_1)
        desc_2-> optional
        desc_2_id-> optional
        desc_3-> optional
        desc_3_id -> optional
        btns -> optional
        illustration -> mandatory
--}}

<div @if(isset($id)) id="{{$id}}" @endif class="row justify-content-center my-5">

    <div class="col-10 mt-3 order-2
                col-sm-8
                col-md-5 mt-md-0 order-md-1
                col-lg-4
                col-vcenter">

        <div class="row">
            <div class="col-12">
                <h3 @if(isset($title_id)) id="{{ $title_id }}" @endif class="h3 text-wrap text-break vpg-desc">{{ $title }}</h3>
                <h6 @if(isset($desc_1_id)) id="{{ $desc_1_id }}" @endif class="h6 font-weight-light text-wrap text-break">{!! $desc_1 !!}</h6>
                @if(isset($desc_2))
                    <h6 @if(isset($desc_2_id)) id="{{ $desc_2_id }}" @endif class="h6 font-weight-light text-wrap text-break">{!! $desc_2 !!}</h6>
                @endif
                @if(isset($desc_3))
                    <h6 @if(isset($desc_3_id)) id="{{ $desc_3_id }}" @endif class="h6 font-weight-light text-wrap text-break">{!! $desc_3 !!}</h6>
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

    <div class="col-10 order-1
                col-sm-8
                col-md-5 order-md-2
                col-lg-4
                text-center col-vcenter">
        <img class="w-100" src="{{ asset('images/illustrations/'. $illustration ) }}">
    </div>
</div>