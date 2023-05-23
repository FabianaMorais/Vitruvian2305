function generateApiKey() {
    $('#btn_generate_key').addClass('running');
    $('#btn_generate_key').addClass('vdisabled');

    $('#err_generate_key').removeClass('d-block');

    $.ajax({
        type: "POST",
        url: generateKeyUrl,
        context: this,
        success: function(data) {
            $('#btn_generate_key').removeClass('running');
            $('#btn_generate_key').removeClass('vdisabled');
            $('#btn_generate_key').hide();
            $('#err_generate_key').hide();

            $('#txt_generate_key').hide();
            $('#txt_generate_key').empty();
            $('#txt_generate_key').append(txtHasKey);
            $('#txt_generate_key').fadeIn('slow');

            $('#txt_api_key').empty();
            $('#txt_api_key').append(data.key);
            $('#panel_api_key').fadeIn('slow');

        },
        error: function(err) {
            $('#btn_generate_key').removeClass('running');
            $('#btn_generate_key').removeClass('vdisabled');

            $('#err_generate_key').addClass('d-block');
        }
    });

}