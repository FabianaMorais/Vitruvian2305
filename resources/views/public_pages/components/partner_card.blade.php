{{-- Team card
By: Luís Henriques on 02/03/200

Slots:
    img_src
    title
 --}}

<div class="card vstyle-main" @if(!isset($large)) style="width:200px; height: 100%;" @else style="min-width: 200px; max-width: 300px; height: 100%;" @endif>
    <div class="card-header vstyle-light">
        <div class="row">
            <div class="col-12 col-vcenter text-center" style="height: 110px;">
                <img class="mx-auto" style="width:110px;" src="{{$img_src}}">
            </div>
        </div>
    </div>

    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{!! $title !!}</h5>
        @isset($text)
            <p class="card-text">{!! $text !!}</p>
        @endif
        @isset($website_link)
            <div class="row align-items-end flex-grow-1"> {{-- Secondary text snaps to bottom --}}
                <div class="col-12">
                    <p class="card-text"><small><a class="vtxt-link" href="{{ $website_link }}" target="_blank">@lang('generic.VISIT_WEBSITE')</a></small></p>
                </div>
            </div>
        @endif
    </div>
</div>