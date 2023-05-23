function openChangePwPanel() {
    $('#collapse_change_pw').collapse('toggle');
}

function resetChangePwPanel() {
    $('#in_old_pw').val('')
    $('#in_new_pw').val('')
    $('#in_new_pw_confirmation').val('')

    $('#panel_change_pw_success').hide();
    $('#panel_change_pw_loading').hide();
    $('#panel_change_pw_error').hide();
    $('#panel_change_pw').show();

    $('#collapse_change_pw').collapse('hide');
}

function changePassword() {

    cleanFormFeedback();
    if (isEmpty('in_old_pw', 'in_old_pw_fb' )) {return false;}
    if (isNotAtLeast(6, 'in_old_pw', 'in_old_pw_fb' )) {return false;}
    if (isEmpty('in_new_pw', 'in_new_pw_fb_size' )) {return false;}
    if (isNotAtLeast(8, 'in_new_pw', 'in_new_pw_fb_size' )) {return false;}

    var oldPw = $('#in_old_pw').val();
    var newPw = $('#in_new_pw').val();
    var confirmPw = $('#in_new_pw_confirmation').val();

    if (newPw != confirmPw) {
        $('#in_new_pw').addClass('is-invalid');
        $('#in_new_pw_confirmation').addClass('is-invalid');
        $('#in_new_pw_fb_match').addClass('d-block');
        centerInput('in_new_pw');
        return false;
    }

    $('#panel_change_pw').hide();
    $('#panel_change_pw_loading').show();

    sendData = {
        old_pw: oldPw,
        new_pw: newPw,
        new_pw_confirmation: confirmPw,
    };

    $.ajax({
        type: "POST",
        url: changePwUrl,
        context: this,
        data: sendData,
        success: function(data) {
            $('#panel_change_pw_loading').hide();
            $('#panel_change_pw_success').show();
        },
        error: function(err) {

            if (err.status == 401) { // Wrong password
                $('#in_old_pw').addClass('is-invalid');
                $('#in_old_pw_fb').addClass('d-block');
                $('#panel_change_pw_loading').hide();
                $('#panel_change_pw').show();
                centerInput('in_old_pw');
            } else {
                $('#panel_change_pw_loading').hide();
                $('#panel_change_pw_error').show();
                console.log('[ERROR ' + err.status + "]: " + err.responseText);
            }
        }
    });
}