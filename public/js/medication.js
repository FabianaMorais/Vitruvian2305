function setTreatmentFinish(p_med_id){
    sendData = {
        pat_med_id: p_med_id
    }
    $.ajax({
        type: "POST",
        url: "/delete-medication",
        context: this,
        data: sendData,
        success: function(data) {
            if($('#med_calendar .selected')[0]){
                $('#med_calendar .selected').click()
                
            }else{
                $('#med_calendar .now').click()
            }

        },
        error: function(err) {
            console.log(err)
        }
    });
}


function showTreatmentEdition(treatment_id) {
    $('#pat_desc_med_tab').hide()
            
    $('#edit_med_loading').show()
    sendData = {
        pat_med_id: treatment_id
    }
    $.ajax({
        type: "POST",
        url: "/get-medication-data",
        context: this,
        data: sendData,
        success: function(data) {
            console.log("success")
            $('#edit_med_loading').hide()
            $('#edit_med_tab').show()
            console.log(data)
            $('#edit_med_name').val(data.medication_data.name) ;
            $('#edit_med_dosage').val(parseInt(data.medication_data.pill_dosage));
            document.getElementById('edit_med_type').value = data.medication_data.type;
            $('#edit_med_number_of_takings').text(data.nr_of_pills_each_intake.length) ;
            $('#edit_med_periodicity').text(data.periodicity) ;
            if(data.end_date == null) {
                $('#edit_undefined_treatment_duration').prop('checked', true)
            }else{
                $('#edit_defined_treatment_duration').prop('checked', true)
                $('#edit_med_treatment_duration').val(parseInt(data.treatment_duration))
                $('#edit_treatment_duration_collapse').collapse('show');
            }
            for( i=0; i<data.nr_of_pills_each_intake.length; i++){
                
                if(i==0){
                    // add to existing fields
                    $('#edit_med_taking_amount').val(data.nr_of_pills_each_intake[i])
                    $('#edit_med_taking_hours').val(data.scheduled_intakes[i].hour)
                    $('#edit_med_taking_mins').val(data.scheduled_intakes[i].minute)
                }
                else{
                    var html_to_add = '<div class="row edit-med-row-entry">'+
                    '<div class="col-12 col-md-6 text-left">'+
                        // {{-- number of pills in the taking--}}
                        '<label for="edit_med_taking_amount"> '+ $('#edit_amount_to_take_lbl_val').val()+' </label>'+
                        '<input type="number" min="0" value="' + data.nr_of_pills_each_intake[i] + '" class="form-control " name="edit_med_taking_amount" id="edit_med_taking_amount" >'+
                    '</div>'+
                    '<div class="col-12 col-md-6 text-left">'+
                        // {{-- time for first taking--}}
                        '<div class="row">'+
                            '<div class="col-6">'+
                                '<label for="edit_med_taking_hours">'+ $('#edit_hours_to_take_lbl_val').val() + '</label>'+
                                '<input type="number" min="0" value="' + data.scheduled_intakes[i].hour + '" max="23" class="form-control " name="edit_med_taking_hours" id="edit_med_taking_hours" >'+  
                            '</div>'+
                            '<div class="col-6">'+
                                '<label for="edit_med_taking_mins">'+ $('#edit_minutes_to_take_lbl_val').val()  +'</label>'+
                                '<input type="number" min="0" value="' + data.scheduled_intakes[i].minute + '" max="23" class="form-control " name="edit_med_taking_mins" id="edit_med_taking_mins" >  '+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'
                $('#edit_med_taking_entries').append(html_to_add);

                }
            }
            
            


        },
        error: function(err) {
            console.log(err)
        }
    });
    $('#edit_med_id').val(treatment_id)
}

$('#edit_defined_treatment_duration').on('change',function(){
    $('#edit_treatment_duration_collapse').collapse('show');
})

$('#edit_undefined_treatment_duration').on('change',function(){
    $('#edit_treatment_duration_collapse').collapse('hide');
})

//periodicity toggling
function editAddToPeriodicity(){
    $('#edit_med_periodicity').text(parseInt($('#edit_med_periodicity').text()) + 1 );
}

function editSubtractFromPeriodicity(){
    if(parseInt($('#edit_med_periodicity').text())>1){
        $('#edit_med_periodicity').text(parseInt($('#edit_med_periodicity').text()) - 1) ;
    }
}

//number of takings toggle
function editAddToNumberOfTakings(){
    $('#edit_med_number_of_takings').text(parseInt($('#edit_med_number_of_takings').text()) + 1 );
    var html_to_add = '<div class="row edit-med-row-entry">'+
        '<div class="col-12 col-md-6 text-left">'+
            // {{-- number of pills in the taking--}}
            '<label for="edit_med_taking_amount"> '+ $('#edit_amount_to_take_lbl_val').val()+' </label>'+
            '<input type="number" min="0" value="0" class="form-control " name="edit_med_taking_amount" id="edit_med_taking_amount" >'+
        '</div>'+
        '<div class="col-12 col-md-6 text-left">'+
            // {{-- time for first taking--}}
            '<div class="row">'+
                '<div class="col-6">'+
                    '<label for="edit_med_taking_hours">'+ $('#edit_hours_to_take_lbl_val').val() + '</label>'+
                    '<input type="number" min="0" val="0" max="23" class="form-control " name="edit_med_taking_hours" id="edit_med_taking_hours" >'+  
                '</div>'+
                '<div class="col-6">'+
                    '<label for="edit_med_taking_mins">'+ $('#edit_minutes_to_take_lbl_val').val()  +'</label>'+
                    '<input type="number" min="0" val="0" max="23" class="form-control " name="edit_med_taking_mins" id="edit_med_taking_mins" >  '+
                '</div>'+
            '</div>'+
        '</div>'+
    '</div>'
    $('#edit_med_taking_entries').append(html_to_add);


}
function editSubtractFromNumberOfTakings(){
    if(parseInt($('#edit_med_number_of_takings').text())>1){
        $('#edit_med_number_of_takings').text(parseInt($('#edit_med_number_of_takings').text()) - 1) ;
        var takings_list = document.getElementsByClassName('edit-med-row-entry');
        var subtracted_html = ''
        for (var counter in takings_list) {
            if(counter == takings_list.length - 1){
                break;
            }
            subtracted_html = subtracted_html +'<div class="row edit-med-row-entry">'+ takings_list[counter].innerHTML + '</div>';
        }
        $('#edit_med_taking_entries').html(subtracted_html);

    }
    
}

function closeMedEdition(){
    $('#edit_med_tab').hide()
    $('#pat_desc_med_tab').show()
    if($('#med_calendar .selected')[0]){
        $('#med_calendar .selected').click()
        
    }else{
        $('#med_calendar .now').click()
    }
}

function editMedicationReq(){
    editRemoveInvalidFeedbacksMedForm()
    if($('#edit_med_name').val() == ''){
        $('#edit_med_name').addClass('is-invalid');
        return false;
    }
    if($('#edit_med_dosage').val() <= 0){
        $('#edit_med_dosage').addClass('is-invalid');
        return false;
    }

    sendData = {
        pat_med_id: $('#edit_med_id').val(),
        medication_name: $('#edit_med_name').val() ,
        medication_dosage: $('#edit_med_dosage').val() ,
        medication_type: $('#edit_med_type').val() ,
        patient_id: $('#searchbar').val(),
        periodicity: parseInt($('#edit_med_periodicity').text()),
        
    };
        var takings_list = document.getElementsByClassName('edit-med-row-entry');
        var counter1;
        sendData['nr_of_pills_each_intake'] = [];
        sendData['scheduled_intakes'] = [];
        for(counter1 = 0; counter1 < takings_list.length; counter1 ++){
            var input_vals = takings_list[counter1].getElementsByClassName('form-control')
            if(parseInt(input_vals[0].value)<=0){
                input_vals[0].classList.add("is-invalid");
                return false;
            }
            if(parseInt(input_vals[1].value)<0 && parseInt(input_vals[1].value)>23 || !input_vals[1].value ){
                input_vals[1].classList.add("is-invalid");
                return false;
            }
            if(parseInt(input_vals[2].value)<0 && parseInt(input_vals[2].value)>59 || !input_vals[2].value ){
                input_vals[2].classList.add("is-invalid");
                return false;
            }
            sendData['nr_of_pills_each_intake'].push(parseInt(input_vals[0].value));
            sendData['scheduled_intakes'].push([ parseInt(input_vals[1].value) , parseInt(input_vals[2].value) ]);
        }
        if(document.getElementById('edit_undefined_treatment_duration').checked) {
            sendData["treatment_duration"] =  -1 ;
        }else if(document.getElementById('edit_defined_treatment_duration').checked) {
            if($('#edit_med_treatment_duration').val() <= 0){
                $('#edit_med_treatment_duration').addClass('is-invalid');
                return false;
            }
            sendData["treatment_duration"] = $('#edit_med_treatment_duration').val() 
        }else{
            $('#edit_med_treatment_duration_error').show();
            return false;   
        }
        $('#edit_med_tab').hide()
        $('#edit_med_loading').show()
    $.ajax({
        type: "POST",
        url: "/edit-med-schedule",
        context: this,
        data: sendData,
        success: function(data) {
            console.log("success")
            $('#edit_med_tab').html(data.reset_form_html)
            $('#edit_med_loading').hide()
            $('#pat_desc_med_tab').show()
            if($('#med_calendar .selected')[0]){
                $('#med_calendar .selected').click()
                
            }else{
                $('#med_calendar .now').click()
            }
        },
        error: function(err) {
            console.log(err)
            
        }
    });
}

function editRemoveInvalidFeedbacksMedForm(){
    $('#edit_med_name').removeClass('is-invalid');
    $('#edit_med_dosage').removeClass('is-invalid');
    $('#edit_med_pills_in_morning').removeClass('is-invalid');
    $('#edit_med_pills_at_lunch').removeClass('is-invalid');
    $('#edit_med_pills_at_night').removeClass('is-invalid');
    $('#edit_med_treatment_duration').removeClass('is-invalid');
    $('#edit_med_treatment_duration_error').hide();
    var takings_list = document.getElementsByClassName('edit-med-row-entry');
    var counter1;
    for(counter1 = 0; counter1 < takings_list.length; counter1 ++){
        var input_vals = takings_list[counter1].getElementsByClassName('form-control')
        input_vals[0].classList.remove("is-invalid");
        input_vals[1].classList.remove("is-invalid");
        input_vals[2].classList.remove("is-invalid");
    }
}