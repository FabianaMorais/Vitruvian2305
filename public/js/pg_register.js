$(function() {

    // if we cannot find the flag that checks that we are returning from form submission errors
    if ($('#regist_with_errors').length == 0) {
        $("input[name='rb_regist']").prop('checked', false); // we clear the radio buttons
    }

    $("input[name='rb_regist']").change(function() {

        hideRegistrationPanels();
        switch($("input[name='rb_regist']:checked").val()) {
            case "organization":
                $('#panel_regist_organization').fadeIn();
                break;
            default: // includes "professional"
                $('#panel_regist_professional').fadeIn();
                break;
        }
    });

    $("input[name='rb_regist_pro_type']").change(function() {

        $('#regist_pro_header_res').hide();
        $('#regist_pro_header_doc').hide();
        $('#regist_pro_header_care').hide();

        $('#regist_descript_pro_res').hide();
        $('#regist_descript_pro_doc').hide();
        $('#regist_descript_pro_care').hide();

        switch($("input[name='rb_regist_pro_type']:checked").val()) {
            case "researcher":
                $('#regist_pro_header_res').show();
                $('#regist_descript_pro_res').fadeIn();
                break;
            case "doctor":
                $('#regist_pro_header_doc').show();
                $('#regist_descript_pro_doc').fadeIn();
                break;
            default: // includes "caregiver"
                $('#regist_pro_header_care').show();
                $('#regist_descript_pro_care').fadeIn();
                break;
        }
    });

    // custom organization for professionals
    $("#pro_organization").change(function () {
        if ($("#pro_organization").val() === "") {
            $('#reg_form_pro_custom_organization').fadeIn();
        } else {
            $('#reg_form_pro_custom_organization').hide();
        }
    });
});

function hideRegistrationPanels() {
    $('#panel_regist_professional').hide();
    $('#panel_regist_organization').hide();
}

$( document ).ready(function() {
   
    switch($("input[name='rb_regist']:checked").val()) {
        case "organization":
            $( "#rb_regist_organization" ).click();
            break;
        default: // includes "professional"
            $( "#rb_regist_professional" ).click();
           
            break;
    }
});