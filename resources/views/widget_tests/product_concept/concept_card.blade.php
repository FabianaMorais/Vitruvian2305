<div class="card-concept">
    <figure class="effect-square col-vcenter">
        <img @if(isset($shadow)) class="shadow" @endif src="{{ $image }}"/>
        <figcaption>
            <h2>{{ $title }}</h2>
            <div class="text-box col-vcenter">
                <p>{{ $text }}</p>
                <a href="{{ $btn_link }}">{{ $btn_text }}</a>
            </div>
        </figcaption>
    </figure>
</div>