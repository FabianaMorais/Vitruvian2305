@extends('base.page_app')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="h1">@lang('pg_manage_pros.EDIT_PRO_TITLE')</h1>
        </div>
    </div>

    @component('professionals.record.pro_record_edit', ['pro_entry' => $pro_entry])
        @slot('postRoute') {{ route('org.manage.pros.save_edit') }} @endslot
        @slot('extraBtns')
            <button type="button" class="btn btn-sm vbtn-negative" data-toggle="modal" data-target="#md_confirm_delete_pro"><i class="fas fa-user-slash"></i> {{ucfirst(trans('generic.REMOVE'))}}</button>
        @endslot
    @endcomponent

    {{-- Remove confirmation modal --}}
    <div id="md_confirm_delete_pro" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header vstyle-negative">
                    <h5 class="h5 modal-title">@lang('pg_manage_pros.CONFIRM_DELETE_TITLE')</h5>
                </div>
                <div class="modal-body">
                    @lang('pg_manage_pros.CONFIRM_DELETE_TXT')
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('org.manage.pros.delete', $pro_entry->key) }}">
                        @csrf
                        <button type="submit" class="btn vbtn-negative">{{ucfirst(trans('generic.REMOVE'))}}</button>
                    </form>
                    <button type="button" class="btn vbtn-support" data-dismiss="modal">{{ucfirst(trans('generic.CANCEL'))}}</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Remove confirmation modal --}}

@endsection