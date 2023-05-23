@extends('base.page_app')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="h1">@lang('pg_manage_pros.TITLE')</h1>
        </div>
    </div>
    
    @if(count($org_pros) > 0)
        <div class="row" style="min-height: 80vh">

            {{-- Info panel --}}
            <div class="col-12 order-2 col-vcenter
                        col-md-7 order-md-1
                        col-lg-8">

                <div id="panel_pro_start" class="row my-5 async-panel">
                    <div class="col-8 offset-2 text-center col-vcenter
                                col-sm-6 offset-sm-3
                                col-md-6 offset-md-3
                                col-lg-4 offset-lg-4">
                        <img class="w-100" src="{{ asset('images/illustrations/search_pro.png') }}">
                    </div>
                    <div class="col-12 mt-3 text-center">
                        <h5 class="h5 font-weight-light">@lang('pg_manage_pros.SEARCH_START')</h5>
                    </div>
                </div>

                @component('widgets.panel_loading')
                    @slot('id') panel_pro_loading @endslot
                @endcomponent

                @component('widgets.panel_error')
                    @slot('id') panel_pro_error @endslot
                @endcomponent

                <div id="panel_pro_info" class="row h-100 async-panel my-md-3 mr-lg-4" style="display: none"> {{-- Canvas for professional info --}}
                    <div id="canvas_pro_info" class="col-12 mx-lg-4">
                        {{-- Append professional record here --}}
                    </div>
                </div>

            </div>
            {{-- Info panel --}}


            <div class="col-12 order-1 mb-4
                        col-md-5 order-md-2 mb-md-0
                        col-lg-4
                        d-flex flex-column">

                {{-- Buttons --}}
                <div class="row">
                    <div class="col-12 text-right my-1">
                        <button id="btn_edit_pro" onclick="editPro()" type="button" class="btn vbtn-main vdisabled">
                            <i class="fas fa-user-edit"></i>
                        </button>

                        <a type="button" class="btn vbtn-main" href="{{ route('org.manage.pros.new') }}">
                            <i class="fas fa-user-plus"></i>
                        </a>
                    </div>
                </div>
                {{-- Buttons --}}

                {{-- List --}}
                <div class="row flex-grow-1">
                    <div class="col-12">
                        <div class="h-100 overflow-auto position-relative my-1" style="min-height: 210px"> {{-- List canvas --}}
                            <div class="position-absolute w-100"> {{-- List scrollable area --}}

                                @foreach($org_pros as $entry)
                                    <a onclick="selectPro( '{{ $entry->key }}', this )" href="#" class="list-group-item list-group-item-action py-1">
                                        <div class="row">
                                            <div class="col-auto col-vcenter">
                                                <img class="rounded-circle my-1" style="width: 40px; height: 40px; object-fit: cover;" src="{{ asset('user_uploads/avatars/' . $entry->avatar) }}">
                                            </div>
                                            <div class="col col-vcenter text-break">
                                                {{ $entry->name }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                {{-- List --}}

            </div>

        </div>

    @else
        {{-- Empty panel --}}
        <div class="row my-5" style="min-height: 60vh;">

            <div class="col-12 offset-0 col-vcenter mt-3 order-2
                        col-sm-10 offset-sm-1
                        col-md-6 offset-md-0 order-md-1 mt-md-0
                        col-lg-4 offset-lg-2" >

                <div class="row">
                    <div class="col-12">
                        <h3 class="h3">@lang('pg_manage_pros.EMPTY_MSG_TITLE')</h3>
                        <h6 class="h6 font-weight-light">@lang('pg_manage_pros.EMPTY_MSG_A')</h6>
                        <h6 class="h6 font-weight-light">@lang('pg_manage_pros.EMPTY_MSG_B')</h6>
                    </div>

                    <div class="col-12">
                        <a class="btn vbtn-main float-right" href="{{ route('org.manage.pros.new') }}">@lang('pg_manage_pros.EMPTY_MSG_BTN')</a>
                    </div>
                </div>
            </div>

            <div class="col-12 text-center col-vcenter order-1
                        col-sm-8 offset-sm-2
                        col-md-6 offset-md-0 order-md-2
                        col-lg-4">
                <img class="w-100" src="{{ asset('images/illustrations/manage_pros.png') }}">
            </div>

        </div>
        {{-- Empty panel --}}
    @endif

@endsection

@section('js')
    @parent
    <script type="text/javascript">
        viewProUrl = {!! json_encode(route('pros.ui.record'), JSON_HEX_TAG) !!};
        editProUrl = {!! json_encode(route('org.manage.pros.edit', ""), JSON_HEX_TAG) !!};
    </script>
    <script type="text/javascript" src="{{ asset('js/pg_manage_pros.js') }}"></script>
@endsection
