{{--
    SLOTS:
        onclick: onClick event
        icon: the icon to be displayed
        text: the text to be displayed
        badge_count: if set, shows a badge with a number. If number is 0, shows a grey badge
--}}

<div class="vdashboard-item my-2" onclick="{{$onclick}}">


    <div class="row" style="height: 60%;">
        <div class="col-12 col-vcenter h-100">
            <h1 class="h1 m-0 p-0">{!! $icon !!}</h1>

            @isset($badge_count) {{-- Badge --}}
                @if($badge_count == "0")
                    <div class="vbadge-empty" style="right: 40px; top: 10px;">0</div>
                @else
                    <div class="vbadge" style="right: 40px; top: 10px;">{{ $badge_count }}</div>
                @endif
            @endif {{-- Badge --}}

        </div>
    </div>
    <div class="row" style="height: 40%;">
        <div class="col-12 col-vcenter px-4">
            <small><strong>{{$text}}</strong></small>
        </div>
    </div>
</div>