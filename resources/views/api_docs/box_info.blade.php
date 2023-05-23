{{-- Information Box
    Slots:
        icon: optional - Font awesome icon
        text: required
--}}
<div class="alert alert-main my-3 text-left text-break " role="alert">

    @if(isset($icon))
    <div class="row"> {{-- This structure is only present if there's an icon to display --}}
        <div class="col-auto text-center">
            <h3>{{ $icon }}</h3>
        </div>
        <div class="col">
    @endif

        {{ $text }}

    @if(isset($icon))
        </div>
    </div>
    @endif

</div>