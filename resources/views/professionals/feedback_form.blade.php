@extends('base.page_app')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1 class="h1">@lang('pg_professionals.PG_FEEDBACK_FORM_TITLE')</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            @component('widgets.illustration_panel_h')
                @slot('illustration') send_feedback.png @endslot
                @slot('title') @lang('pg_professionals.FEEDBACK_FORM_TITLE') @endslot
                @slot('desc_1') @lang('pg_professionals.FEEDBACK_FORM_TEXT_A') @endslot
                @slot('desc_2') @lang('pg_professionals.FEEDBACK_FORM_TEXT_B') @endslot
            @endcomponent

        </div>
    </div>

    <div class="row">

        <div class="col-12 offset-0
                    col-sm-10 offset-sm-1
                    col-lg-8 offset-lg-2">
            <div class="form-group">
                <textarea id="in_feedback_msg" name="in_feedback_msg" class="form-control" rows="10" maxlength="50000" placeholder="@lang('pg_professionals.YOUR_FEEDBACK_PH')"></textarea>
            </div>
            <div><div id="in_feedback_msg_fb" class="invalid-feedback"></div></div>
        </div>

        <div class="col-12 offset-0 text-center
                    col-sm-10 offset-sm-1 text-sm-right
                    col-lg-8 offset-lg-2">

            <div class="mb-3"><div id="msg_feedback_sent" class="valid-feedback">Your message was sent.<br>Thank you.</div></div>

            <button id="btn_update_profile" class="btn vbtn-main ld-ext-right hovering" onClick="sendFeedback()">
                @lang('pg_professionals.BTN_SEND_FEEDBACK')
                <div class="ld ld-ring ld-spin-fast"></div>
            </button>
        </div>

    </div>


@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/form_validations.js') }}"></script>
    <script type="text/javascript">
        formErrorMsg = {!! json_encode( trans('generic.ONE_LINE_ERROR_MSG'), JSON_HEX_TAG) !!};
        sendFeedbackUrl = {!! json_encode(route('beta.feedback.send'), JSON_HEX_TAG) !!};
    </script>
    <script type="text/javascript" src="{{ asset('js/feedback_form.js') }}"></script>
@endsection