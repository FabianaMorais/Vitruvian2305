function openSettings() {
    $('#panel_manage_settings_error').hide();
    $('#panel_manage_settings_loading').hide();
    $('#btn_manage_settings_save').removeClass('vdisabled');
    $('#panel_manage_settings_list').show();
    $('#md_manage_settings').modal('show');
}

function submitSettings() {

    // input validations
    cleanFormFeedback();
    if (isEmpty('in_name', 'in_name_fb' )) {return false;}
    if (isNotAtLeast(5, 'in_name', 'in_name_fb' )) {return false;}
    if (isEmpty('in_description', 'in_description_fb' )) {return false;}
    if (isNotAtLeast(5, 'in_description', 'in_description_fb' )) {return false;}

    $('#panel_manage_settings_error').hide();
    $('#panel_manage_settings_list').hide();
    $('#btn_manage_settings_save').addClass('vdisabled');
    $('#panel_manage_settings_loading').show();

    sendData = {
        key: $('#team_key').val(),
        name: $('#in_name').val(),
        description: $('#in_description').val(),
    };

    $.ajax({
        type: "POST",
        url: updateSettingsUrl,
        context: this,
        data: sendData,
        success: function(data) {
            $('#txt_team_name').empty();
            $('#txt_team_name').append( $('#in_name').val() );

            $('#txt_team_description').empty();
            $('#txt_team_description').html( $('#in_description').val().replace(/\n/g,'<br/>') );

            $('#btn_manage_settings_save').removeClass('vdisabled');
            $('#md_manage_settings').modal('hide');
        },
        error: function(err) {
            $('#panel_manage_settings_loading').hide();
            $('#btn_manage_settings_save').removeClass('vdisabled');
            $('#panel_manage_settings_error').show();
            console.log('[ERROR ' + err.status + "]: " + err.responseText);
        }
    });
}

function clickDelete() {
    $('#md_manage_settings').modal('hide');

    setTimeout(function(){
        $('#md_manage_confirm_delete').modal('show');
    },400);
}