{{--
    Slots:
        @slot('icon') {{ asset('images/placeholders/icon.png') }} @endslot
        @slot('title') Title @endslot
        @slot('text') Text lalala 123123 123123 ahaklh khfaskah lfs @endslot

--}}

<div class="vico-box mx-auto">
    <div class="vico-box-ico">
        <figure class="vico-box-img" data-status="verified">
            <img src="{{ $icon }}" alt="Rogie" />
        </figure>
    </div>

    <h2 class="vico-box-title">{{ $title }}</h2>
    <div class="vico-box-text text-break">
        <p>{{ $text }}</p>
    </div>
</div>