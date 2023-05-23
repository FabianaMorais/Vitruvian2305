{{--
    Sidebar option

    Slots:
        inactive if both onClick nor link are set
        icon: This entry's icon
        text: This entry's text
        onClick: Function call for onClick events
        link: link
--}}
<div class="sidebar-option @if(!isset($onClick) && !isset($link)) inactive @endif"
    @if(isset($onClick)) onClick="{{$onClick}}" @endif
    @if(isset($link)) onClick="window.location.href='{{$link}}'" @endif
    >

    <div class="sidebar-opt-ico">
        @if(isset($icon))
            {!! $icon !!}
        @endif
    </div>
    <div class="sidebar-opt-txt">
        @if(isset($text))
            {!! $text !!}
        @endif
    </div>
</div>