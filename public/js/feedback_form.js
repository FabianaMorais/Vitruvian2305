function sendFeedback() {

    cleanFormFeedback();

    $('#btn_update_profile').addClass('running');
    $('#btn_update_profile').addClass('vdisabled');

    sendData = {
        in_feedback_msg: $('#in_feedback_msg').val(),
    };

    $.ajax({
        type: "POST",
        url: sendFeedbackUrl,
        context: this,
        data: sendData,
        success: function(data) {
            $('#btn_update_profile').removeClass('running');
            $('#btn_update_profile').removeClass('vdisabled');

            $('#msg_feedback_sent').addClass('d-block');
            $('#in_feedback_msg').val('');

        },
        error: function(err){
            $('#btn_update_profile').removeClass('running');
            $('#btn_update_profile').removeClass('vdisabled');

            handleRequestErrors(err);

            if (err.status != 422) { // handle non validation errors
                $('#in_feedback_msg_fb').empty();
                $('#in_feedback_msg_fb').append(formErrorMsg);
                $('#in_feedback_msg_fb').addClass('d-block');
            }
        }
    });
}
