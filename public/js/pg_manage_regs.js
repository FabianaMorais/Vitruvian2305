$(function() {
    if ($('#sel_amr_registrations').val()) {
        selectNewEntry();

    } else {
        $('#panel_amr_empty').show();
    }
});

function hideAMRPanels() {
    $('panel_amr_empty').hide();
    $('#panel_amr_entry').hide();
    $('#panel_amr_error').hide();
    $('#panel_amr_loading').hide();
    $('#panel_amr_success').hide();
}

function selectNewEntry() {
    var selection = $('#sel_amr_registrations').val();
    getEntry(selection);
}

function getEntry(en) {
    hideAMRPanels();
    $('#panel_amr_loading').show();

    sendData = {
        entry: en,
    };

    $.ajax({
        type: "GET",
        url: "/admin/registrations/view",
        context: this,
        data: sendData,
        success: function(data) {
            $('#amr_entry').empty();
            $('#amr_entry').append(data.entry_view);

            $('#panel_amr_loading').hide();
            $('#panel_amr_entry').show();
        },
        error: function(err) {
            $('#panel_amr_loading').hide();
            $('#panel_amr_error').show();
            console.log('[ERROR ' + err.status + "]: " + err.responseText);
        }
    });
}

function acceptEntry(en) {

    if (en == null) { return; }

    hideAMRPanels();
    $('#panel_amr_loading').show();
    $('#md_amd_confirm_accept').modal('hide');

    sendData = {
        entry: en,
    };

    $.ajax({
        type: "POST",
        url: "/admin/registrations/accept",
        context: this,
        data: sendData,
        success: function() {
            $('#panel_amr_loading').hide();
            $('#panel_amr_success').show();
            $("#sel_amr_registrations option[value='" + en + "']").append(' (' + $('#txt_amr_entry_accepted').val() + ')');
            $("#sel_amr_registrations option[value='" + en + "']").attr("disabled", "disabled");
        },
        error: function(err) {
            $('#panel_amr_loading').hide();
            $('#panel_amr_error').show();
            console.log('[ERROR ' + err.status + "]: " + err.responseText);
        }
    });
}

function refuseEntry(en) {

    if (en == null) { return; }

    hideAMRPanels();
    $('#panel_amr_loading').show();
    $('#md_amd_confirm_refuse').modal('hide');

    sendData = {
        entry: en,
    };

    $.ajax({
        type: "POST",
        url: "/admin/registrations/refuse",
        context: this,
        data: sendData,
        success: function() {
            $('#panel_amr_loading').hide();
            $('#panel_amr_success').show();
            $("#sel_amr_registrations option[value='" + en + "']").append(' (' + $('#txt_amr_entry_refused').val() + ')');
            $("#sel_amr_registrations option[value='" + en + "']").attr("disabled", "disabled");
        },
        error: function(err) {
            $('#panel_amr_loading').hide();
            $('#panel_amr_error').show();
            console.log('[ERROR ' + err.status + "]: " + err.responseText);
        }
    });
}