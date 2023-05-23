function clickManageTeamPros() {
    if ( !$.trim( $('#list_manage_pros').html() ).length ) { // Only requests once, if list is empty
        requestOrgProList();

    } else { // displaying appropriate elements if not requesting
        $('#panel_manage_pros_empty').hide();
        $('#panel_manage_pros_loading').hide();
        $('#panel_manage_pros_error').hide();
        $('#btn_manage_pros_save').show();
        $('#panel_manage_pros_list').show();
    }

    $('#fb_manage_pros_req_writer').hide();
    $('#md_manage_pros').modal('show');
}

/**
 * Requests the full list of professionals from the current organization
 * and sets all team data in the UI
 */
function requestOrgProList() {
    // hiding appropriate elements when requesting
    $('#panel_manage_pros_empty').hide();
    $('#panel_manage_pros_error').hide();
    $('#btn_manage_pros_save').hide();
    $('#panel_manage_pros_list').hide();
    $('#panel_manage_pros_loading').show();

    sendData = {
        key: $('#team_key').val(),
    };

    $.ajax({
        type: "GET",
        url: getTeamProsUrl,
        context: this,
        data: sendData,
        success: function(data) {

            $('#panel_manage_pros_loading').hide();

            if (data.length == 0) {
                $('#panel_manage_pros_empty').show();

            } else {
                $('#btn_manage_pros_save').show();
                $('#panel_manage_pros_list').show();

                $('#list_manage_pros').empty();
                $('#list_manage_pros').append(data);
            }

        },
        error: function(err) {
            $('#panel_manage_pros_loading').hide();
            $('#panel_manage_pros_error').show();
            console.log('[ERROR ' + err.status + "]: " + err.responseText);
        }
    });
}

/**
 * Submits a list of all selected professionals,
 * along with their role and access levels
 */
function submitListOfPros() {

    var proEntries = $('.team-pro-entry');

    var hasWriter = false;

    var selectedPros = [];
    for (var i = 0; i < proEntries.length; i ++) {

        var currentKey = $(proEntries[i]).val();

        if ( $('#cb_' + currentKey ).is(':checked')) {

            sPro = {
                key: currentKey,
                role: $('#role_' + currentKey ).val(),
                access: $('#access_' + currentKey ).val(),
            };

            if (!hasWriter && sPro.access == 'write') {
                hasWriter = true;
            }

            selectedPros.push(sPro);
        }
    }

    if (!hasWriter) {
        $('#fb_manage_pros_req_writer').show();
        return false;
    }
    
    $('#fb_manage_pros_req_writer').hide();
    $('#panel_manage_pros_empty').hide();
    $('#panel_manage_pros_error').hide();
    $('#panel_manage_pros_list').hide();
    $('#btn_manage_pros_save').addClass('vdisabled');
    $('#panel_manage_pros_loading').show();

    sendData = {
        key: $('#team_key').val(),
        pros: selectedPros,
    };

    $.ajax({
        type: "POST",
        url: updateTeamProsUrl,
        context: this,
        data: sendData,
        success: function(data) {

            if(data.members.length == 0 && data.leaders.length == 0) {
                $('#list_pros_leaders').empty();
                $('#panel_pros_leaders_list').hide();
                $('#list_pros_members').empty();
                $('#panel_pros_members_list').hide();
                $('#panel_professionals_empty').show();

            } else { // Updating lists of members
                $('#panel_professionals_empty').hide();

                if (data.leaders.length == 0) {
                    $('#panel_pros_leaders_list').hide();

                } else {
                    $('#panel_pros_leaders_list').show();
                    $('#list_pros_leaders').empty();

                    for (var i = 0; i < data.leaders.length; i ++) {
                        $('#list_pros_leaders').append(data.leaders[i]);
                    }
                }

                if (data.members.length == 0) {
                    $('#panel_pros_members_list').hide();
                } else {
                    $('#panel_pros_members_list').show();
                    $('#list_pros_members').empty();

                    for (var i = 0; i < data.members.length; i ++) {
                        $('#list_pros_members').append(data.members[i]);
                    }
                }

            }
            $('#btn_manage_pros_save').removeClass('vdisabled');
            $('#md_manage_pros').modal('hide');
        },
        error: function(err) {
            $('#panel_manage_pros_loading').hide();
            $('#btn_manage_pros_save').removeClass('vdisabled');
            $('#panel_manage_pros_error').show();
            console.log('[ERROR ' + err.status + "]: " + err.responseText);
        }
    });
}

/**
 * Clicking event for checkboxes in the pro entry
 */
function clickProCb(proKey, cbElement) {
    if($(cbElement).is(':checked')) {
        $('#entry_' + proKey).addClass('active');
        $('#role_panel_' + proKey).show();
        $('#access_panel_' + proKey).show();

    } else {
        $('#entry_' + proKey).removeClass('active');
        $('#role_panel_' + proKey).hide();
        $('#access_panel_' + proKey).hide();
    }
}

/**
 * Resetting makes us fetch the list again
 */
function resetProList() {
    $('#md_manage_pros').modal('hide');
    $('#list_manage_pros').empty();
}

function viewPro(proKey) {
    $('#panel_view_pro_error').hide();
    $('#panel_view_pro_record').hide();
    $('#panel_view_pro_loading').show();

    $('#md_view_pro').modal('show');

    sendData = {
        pro_key: proKey,
    };

    $.ajax({
        type: "GET",
        url: viewProUrl,
        context: this,
        data: sendData,
        success: function(data) {
            $('#pro_record').empty();
            $('#pro_record').append(data.record_ui);

            $('#panel_view_pro_error').hide();
            $('#panel_view_pro_loading').hide();
            $('#panel_view_pro_record').show();

        },
        error: function(err) {
            $('#panel_view_pro_loading').hide();
            $('#panel_view_pro_record').hide();
            $('#panel_view_pro_error').show();
        }
    });

}