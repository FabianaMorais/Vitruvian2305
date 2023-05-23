@extends('base.page_app')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="h1">@lang('api_docs.PG_TITLE')</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            {{-- API Overview Panel --}}
            @component('widgets.illustration_panel_h')
                @slot('illustration') api.png @endslot
                @slot('title') @lang('api_docs.PANEL_TITLE') @endslot
                @slot('desc_1') @lang('api_docs.PANEL_DESC_A') @endslot
                @slot('desc_2') @lang('api_docs.PANEL_DESC_B') @endslot

                @if (!isset($key))
                    @slot('desc_3') @lang('api_docs.PANEL_DESC_GENERATE') @endslot
                    @slot('desc_3_id') txt_generate_key @endslot
                    @slot('btns')
                        <button id="btn_generate_key" class="btn vbtn-main ld-ext-right hovering" onclick="generateApiKey()">
                            @lang('api_docs.BTN_GENERATE_KEY')
                            <div class="ld ld-ring ld-spin-fast"></div>
                        </button>
                        <div id="err_generate_key" class="invalid-feedback">
                            @lang('generic.ONE_LINE_ERROR_MSG')
                        </div>
                    @endslot
                @else
                    @slot('desc_3') @lang('api_docs.PANEL_DESC_DOCS') @endslot
                @endif

            @endcomponent
            {{-- API Overview Panel --}}


            {{-- API key panel --}}
            <div id="panel_api_key" class="row justify-content-center" @if (!isset($key)) style="display:none" @endif>

                <div class="col-auto mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <h2><i class="vicon-main fas fa-key"></i></h2>
                                </div>
                                <div class="col">
                                    <h6 class="h6 mb-1">@lang('api_docs.KEY_TITLE')</h6>
                                    <h6 class="h6 font-weight-light">@lang('api_docs.KEY_DESC')</h6>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-2 text-center">
                            <h4 id="txt_api_key" class="h4 font-weight-bold mt-1 mx-2">@if (isset($key)) {{ $key }} @endif</h4>
                        </div>
                    </div>
                </div>

            </div>
            {{-- API key panel --}}

        </div>
    </div>

@endsection

@if (!isset($key)) {{-- If there is a key already, there is no need to include JS --}}
@section('js')
    @parent
    <script type="text/javascript">
        generateKeyUrl = {!! json_encode(route('public_api.generate_key'), JSON_HEX_TAG) !!};
        txtHasKey = {!! json_encode(trans('api_docs.PANEL_DESC_DOCS'), JSON_HEX_TAG) !!};
    </script>
    <script type="text/javascript" src="{{ asset('js/pg_api_credentials.js') }}"></script>
@endsection
@endif