{{-- Information Box
    Slots:
        icon: optional - Font awesome icon
        method: optional - Method type
        route: optional - API route
        text: optional
        expected: optional - Expected fields for the current request
        returned: optional - returned fields for the returned response
--}}
<div class="alert alert-code my-3 text-left text-break" role="alert">
    <div class="row">

        @if(isset($icon) || isset($method))
            <div class="col-auto text-center">
                @if(isset($method)) <h4 class="h4 mb-0 border border-main rounded py-1 px-2">{{ $method }}</h4> @else <h3>{{ $icon }}</h3> @endif
            </div>
        @endif

        <div class="col text-left">
            @if(isset($route))
                {{ $route }}

                @if (isset($text) || isset($expected) || isset($returned))
                    <hr class="my-2">
                @endif
            @endif

            @if(isset($text))
                {{ $text }}

                @if (isset($expected))
                    <hr class="my-2">
                @endif
            @endif

            @if(isset($expected))
                <div class="row">
                    <div class="col-12">
                        @lang('api_docs.REQUEST_EXPECTED')
                    </div>
                    <div class="col-11 offset-1">
                        {{ $expected }}
                    </div>
                </div>

                @if (isset($returned))
                    <hr class="my-2">
                @endif
            @endif

            @if(isset($returned))
                <div class="row">
                    <div class="col-12">
                    @lang('api_docs.REQUEST_RESPONSE')
                    </div>
                    <div class="col-11 offset-1">
                        {{ $returned }}
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>