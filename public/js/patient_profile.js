function updatePatientProfile(user_key) {

    cleanFormFeedback();

    $('#btn_update_profile').addClass('running');
    $('#btn_update_profile').addClass('vdisabled');

    sendData = {
        user_key: user_key,
        in_gender: $('#in_gender').val(),
        in_weight: $('#in_weight').val(),
        in_b_day: $('#in_b_day').val(),
        in_b_month: $('#in_b_month').val(),
        in_b_year: $('#in_b_year').val(),
        in_blood_type: $('#in_blood_type').val(),
        in_diagnosed: $('#in_diagnosed').val(),
        in_other: $('#in_other').val(),
    };

    $.ajax({
        type: "POST",
        url: updateHealthProfileUrl,
        context: this,
        data: sendData,
        success: function(data) {
            $('#btn_update_profile').removeClass('running');
            $('#btn_update_profile').removeClass('vdisabled');

            // Presenting age
            $('#txt_age').empty();

            if (data.age != null) {
                $('#txt_age').append(data.age);
            } else {
                $('#txt_age').append('-');
            }

        },
        error: function(err) {
            $('#btn_update_profile').removeClass('running');
            $('#btn_update_profile').removeClass('vdisabled');

            handleRequestErrors(err);

            if (err.status != 422) { // handle non validation errors

            }
        }
    });
}

function setHideListener(uKey) {
    $( 'a[data-toggle="tab"]' ).on( 'hide.bs.tab', function( evt ) {

        var tab = $( evt.target ).attr( 'href' );

        if (tab === "#nav-profile") { // Upon leaving the profile tab

            updatePatientProfile(uKey);

            // removing listener so we don't stack multiple listeners
            $( 'a[data-toggle="tab"]' ).off('hide.bs.tab');
        }
    });
}