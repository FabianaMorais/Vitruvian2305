<div class="card p-4 vcard-canvas" style="width: 100%; height:100%;">
        <div class="row mx-auto p-3">
            <div class="col-12 col-vcenter vcard-img">
                <img src="{{ $image }}" style="max-width: 100%; max-height: 100%">
            </div>
        </div>
    <div class="row mx-auto" style="width: 100%;">
        <div class="col-12">

            @if(isset( $card_text ))
            <div class="card-body ">
                <p class="card-text">{{ $card_text }}</p>
            </div>
            @endif

            @if(isset($list_content))
                <ul class="list-group list-group-flush">
                    {{ $list_content }}
                </ul>
            @endif

        </div>
    </div>
</div>