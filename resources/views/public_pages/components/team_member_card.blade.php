{{-- Team card
By: Luís Henriques on 02/03/200

Slots:
    img_src
    title
    text (optional)
    text_b (optional)
 --}}

<div class="card vstyle-main" style="width:200px; height: 100%;">
    <img class="mx-auto mt-3" style="width:110px;height:100px; border-radius: 50%" src="{{$img_src}}">
    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{!! $title !!}</h5>
        @isset($text)
            <p class="card-text">{!! $text !!}</p>
        @endif
        @isset($text_b)
            <div class="row align-items-end flex-grow-1"> {{-- Secondary text snaps to bottom --}}
                <div class="col-12">
                    <p class="card-text"><small class="vtext-clear">{!! $text_b !!}</small></p>
                </div>
            </div>
        @endif
    </div>
</div>