@extends('base.page_app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h1">@lang('pg_manage_regs.TITLE')</h1>
        </div>

        {{-- List selector --}}
        <input id="txt_amr_entry_accepted" type="hidden" value="@lang('generic.ACCEPTED')"> {{-- For JS to show empty msg on list --}}
        <input id="txt_amr_entry_refused" type="hidden" value="@lang('generic.REJECTED')">
        <div class="col-12">
            <div class="form-group row">
                <div class="col-12
                            col-sm-10 offset-sm-1
                            col-md-8 offset-md-2">
                    <select id="sel_amr_registrations" name="sel_amr_registrations" onchange="selectNewEntry();" type="text" class="form-control">
                        
                        @if ( isset($user_list) && count($user_list) > 0 )
                            @foreach($user_list as $key => $name)
                                <option value="{{ $key }}">{{$name}}</option>
                            @endforeach
                        @else
                            <option value="" disabled selected>@lang('generic.STANDARD_EMPTY_MSG')</option>
                        @endif

                    </select>
                </div>
            </div>
        </div>
        {{-- List selector --}}

    </div>

    {{-- Panels --}}
    <div id="panel_amr_entry" class="row">
        <div id="amr_entry" class="col-12
                    col-sm-10 offset-sm-1
                    col-md-8 offset-md-2">

            {{-- Panel to append selected entries --}}

        </div>
    </div>

    @component('widgets.panel_empty')
        @slot('id') panel_amr_empty @endslot
    @endcomponent

    @component('widgets.panel_loading')
        @slot('id') panel_amr_loading @endslot
    @endcomponent

    @component('widgets.panel_error')
        @slot('id') panel_amr_error @endslot
    @endcomponent

    @component('widgets.panel_success')
        @slot('id') panel_amr_success @endslot
    @endcomponent

    {{-- Accept confirmation modal --}}
    <div class="modal fade" id="md_amd_confirm_accept" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header vstyle-main">
                    <h5 class="h5 modal-title">@lang('pg_manage_regs.CONFIRM_ACCEPT')</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn vbtn-main" onclick="acceptEntry($('#amr_entry_key').val())">{{ucfirst(trans('generic.ACCEPT'))}}</button>
                    <button type="button" class="btn vbtn-support" data-dismiss="modal">{{ucfirst(trans('generic.CANCEL'))}}</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Accept confirmation modal --}}

    {{-- Reject confirmation modal --}}
    <div class="modal fade" id="md_amd_confirm_refuse" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header vstyle-negative">
                    <h5 class="h5 modal-title">@lang('pg_manage_regs.CONFIRM_REJECT')</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn vbtn-negative" onclick="refuseEntry($('#amr_entry_key').val())">{{ucfirst(trans('generic.REJECT'))}}</button>
                    <button type="button" class="btn vbtn-support" data-dismiss="modal">{{ucfirst(trans('generic.CANCEL'))}}</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Reject confirmation modal --}}

@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/pg_manage_regs.js') }}"></script>
@endsection