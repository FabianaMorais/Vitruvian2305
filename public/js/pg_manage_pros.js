var selectedPro;

function selectPro(key, uiEntry) {

    $('.list-group-item').removeClass('active');
    $(uiEntry).addClass('active');

    $('.async-panel').hide();
    $('#panel_pro_loading').show();

    $('#btn_edit_pro').addClass('vdisabled');
    selectedPro = null; // reset var

    sendData = {
        pro_key: key,
    };

    $.ajax({
        type: "GET",
        url: viewProUrl,
        context: this,
        data: sendData,
        success: function(data) {
            $('#canvas_pro_info').empty();
            $('#canvas_pro_info').append(data.record_ui);

            $('.async-panel').hide();
            $('#panel_pro_info').show();

            selectedPro = data.key;
            $('#btn_edit_pro').removeClass('vdisabled');

        },
        error: function(err) {
            $('.async-panel').hide();
            $('#panel_pro_error').show();
            $('#btn_edit_pro').addClass('vdisabled');
        }
    });

}

function editPro() {
    if (selectedPro != null) {
        location.href = editProUrl + "/" + selectedPro;
    } else {
        console.log("ERROR: No professional selected");
    }
}