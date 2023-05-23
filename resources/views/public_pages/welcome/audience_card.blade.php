<div class="card-target mt-3">
    <figure class="effect-dexter">
        <img @if(isset($shadow)) class="shadow" @endif src="{{ $image }}"/>
        <figcaption>
            <h2>{{ $title }}</h2>
            <p>{{ $text }}</p>
            <a href="{{ $btn_link }}">{{ $btn_text }}</a>
        </figcaption>
    </figure>
</div>