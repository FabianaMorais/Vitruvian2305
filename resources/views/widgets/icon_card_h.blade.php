{{--
    SLOTS:
        @slot('icon') {{ asset('images/placeholders/icon.png') }} @endslot
        @slot('title') Test Title @endslot
        @slot('text') Test desc @endslot
--}}
<div class="vicon-card">
    <div class="row mb-3">
        <div class="col-auto">
            <img src="{{ $icon }}">
        </div>
        <div class="col">
            <div class="vicon-card-body">
                <span>
                    <h5>{{ $title }}</h5>
                    <p>{{ $text }}</p>
                </span>
            </div>
        </div>
    </div>
</div>