function clickManageTeamPatients() {
    if ( !$.trim( $('#list_manage_patients').html() ).length ) { // Only requests once, if list is empty
        requestOrgPatientList();

    } else { // displaying appatientpriate elements if not requesting
        $('#panel_manage_patients_empty').hide();
        $('#panel_manage_patients_loading').hide();
        $('#panel_manage_patients_error').hide();
        $('#btn_manage_patients_save').show();
        $('#panel_manage_patients_list').show();
    }

    $('#md_manage_patients').modal('show');
}

/**
 * Requests the full list of patients from the current organization
 * and sets all team data in the UI
 */
function requestOrgPatientList() {
    // hiding appatientpriate elements when requesting
    $('#panel_manage_patients_empty').hide();
    $('#panel_manage_patients_error').hide();
    $('#btn_manage_patients_save').hide();
    $('#panel_manage_patients_list').hide();
    $('#panel_manage_patients_loading').show();

    sendData = {
        key: $('#team_key').val(),
    };

    $.ajax({
        type: "GET",
        url: getTeamPatientsUrl,
        context: this,
        data: sendData,
        success: function(data) {

            $('#panel_manage_patients_loading').hide();

            if (data.length == 0) {
                $('#panel_manage_patients_empty').show();

            } else {
                $('#btn_manage_patients_save').show();
                $('#panel_manage_patients_list').show();

                $('#list_manage_patients').empty();
                $('#list_manage_patients').append(data);
            }

        },
        error: function(err) {
            $('#panel_manage_patients_loading').hide();
            $('#panel_manage_patients_error').show();
            console.log('[ERROR ' + err.status + "]: " + err.responseText);
        }
    });
}

/**
 * Submits a list of all selected patients,
 * along with their role and access levels
 */
function submitListOfPatients() {

    $('#panel_manage_patients_empty').hide();
    $('#panel_manage_patients_error').hide();
    $('#panel_manage_patients_list').hide();
    $('#btn_manage_patients_save').addClass('vdisabled');
    $('#panel_manage_patients_loading').show();

    var patientEntries = $('.team-patient-entry');

    var selectedPatients = [];
    for (var i = 0; i < patientEntries.length; i ++) {

        var currentKey = $(patientEntries[i]).val();

        if ( $('#cb_' + currentKey ).is(':checked')) {

            sPatient = {
                key: currentKey,
            };
            selectedPatients.push(sPatient);
        }
    }

    sendData = {
        key: $('#team_key').val(),
        patients: selectedPatients,
    };

    $.ajax({
        type: "POST",
        url: updateTeamPatientsUrl,
        context: this,
        data: sendData,
        success: function(data) {

            if(data.patients.length == 0) {
                $('#list_patients').empty();
                $('#panel_patients_list').hide();
                $('#panel_patients_empty').show();

            } else { // Updating lists of members
                $('#panel_patients_empty').hide();

                $('#panel_patients_list').show();
                $('#list_patients').empty();

                for (var i = 0; i < data.patients.length; i ++) {
                    $('#list_patients').append(data.patients[i]);
                }

            }
            $('#btn_manage_patients_save').removeClass('vdisabled');
            $('#md_manage_patients').modal('hide');
        },
        error: function(err) {
            $('#panel_manage_patients_loading').hide();
            $('#btn_manage_patients_save').removeClass('vdisabled');
            $('#panel_manage_patients_error').show();
            console.log('[ERROR ' + err.status + "]: " + err.responseText);
        }
    });
}

/**
 * Clicking event for checkboxes in the patient entry
 */
function clickPatientCb(patientKey, cbElement) {
    if($(cbElement).is(':checked')) {
        $('#entry_' + patientKey).addClass('active');
        $('#role_panel_' + patientKey).show();
        $('#access_panel_' + patientKey).show();

    } else {
        $('#entry_' + patientKey).removeClass('active');
        $('#role_panel_' + patientKey).hide();
        $('#access_panel_' + patientKey).hide();
    }
}

/**
 * Resetting makes us fetch the list again
 */
function resetPatientList() {
    $('#md_manage_patients').modal('hide');
    $('#list_manage_patients').empty();
}