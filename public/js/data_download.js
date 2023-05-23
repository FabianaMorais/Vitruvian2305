$(function() {
    $('#daterangepicker').daterangepicker({
        "timePicker": true,
        "maxSpan": {
            "days": 7
        },
        
        "startDate": moment().startOf('hour').add(-24, 'hour'),
        "endDate": moment().startOf('hour'),
        "opens": "right",
        "locale": {
            "format": "YYYY-MM-DD H:mm"
        },
        "pick12HourFormat": false    
    });
});

function showTeam(team_name) {
    $('#closed_team_selection_' +team_name ).hide()
    $('#open_team_selection_' +team_name).show()
    //show all patient entries for this team
    $('#patients_' + team_name).slideDown( "slow");
}

function hideTeam(team_name) {
    $('#open_team_selection_' +team_name).hide()
    $('#closed_team_selection_' +team_name).show()
    //hide all patient entries for this team
    $('#patients_' + team_name).slideUp("slow")
}


function selectUser(team_id, patient_id){
    //check if it is being checked or unchecked
    var success = true;
    if($('#patient_' + team_id + '_' + patient_id).is(':checked') == true){
        //if it is being checked, check if all patients in that team are checked too and, 
        $('#patients_team_' + team_id + ' ' + '.custom-control-input').each(function () { //loop through each checkbox
            if(this.checked == false){
                success = false;
                return false;
            }
        });
        //if function gets here it means all patients are checked and team checkbox is also checked
        if(success == true){
            $('#team_' + team_id).prop("checked",true);
        }
        
    }else{
        //if it is being unchecked, check if the team name checkbox is checked, if it is just uncheck it
        if($('#team_' + team_id).is(':checked') == true){
            $('#team_' + team_id).prop("checked",false);
        }
    }  
}

function selectTeam(team_id){
    //check if being checked or unchecked
    if($('#team_' + team_id).is(':checked') == true){
        //if being checked, find all patients inside the team element and check them

        $('#patients_team_' + team_id + ' ' + '.custom-control-input').each(function () { //loop through each checkbox
            //if one patient is not checked, finish function
            this.checked = true
        });
    }else{
        //if being unchecked, find all patients inside the team element and uncheck them
        $('#patients_team_' + team_id + ' ' + '.custom-control-input').each(function () { //loop through each checkbox
            this.checked = false
        });
    }
}


function enableSensorSelection(){
    $('#sensor_1').prop("disabled",false)
    $('#sensor_2').prop("disabled",false)
    $('#sensor_3').prop("disabled",false)
    $('#sensor_4').prop("disabled",false)
    $('#sensor_5').prop("disabled",false)
}

function disableSensorSelection(){
    $('#sensor_1').prop("disabled",true)
    $('#sensor_2').prop("disabled",true)
    $('#sensor_3').prop("disabled",true)
    $('#sensor_4').prop("disabled",true)
    $('#sensor_5').prop("disabled",true)
}



async function downloadData(){
    $('#download_report').hide()
    $('#current_record').text("1")
    $('#no_users_error').hide()
    $('#dd_content').hide()
    $('#dd_loading').show()
    var sendData = {};
    sendData["start_date"] = moment($('input[name="daterange"]').data('daterangepicker').startDate).utc().format("DD/MM/YYYY HH:mm");
    sendData["end_date"] = moment($('input[name="daterange"]').data('daterangepicker').endDate).utc().format("DD/MM/YYYY HH:mm");
    sendData["patient_list"] = []
    $('.list-group.list-group-flush.user-list .custom-control-input').each(function () { //loop through each checkbox
        if(this.checked === true){
            if(!sendData["patient_list"].includes($(this).val())){
                sendData["patient_list"].push($(this).val())
            }
        }
    });
    if(sendData["patient_list"].length === 0){
        $('#no_users_error').show()
        $('#dd_loading').hide()
        $('#dd_content').show()
        return false
    }

    if($('#use_submitted_by_users').is(':checked')){
        sendData['use_submitted_by_users'] = 1;
    }else{
        sendData['use_submitted_by_users'] = 0;
    }
    


    $.ajax({
        type: "POST",
        url: "/data/export",
        context: this,
        data: sendData,
        success: function(data, status) {
            var resulting_object = data;
            var total_buckets = 0;
            var bucket_list_to_query = [];
            resulting_object.forEach(function (item) {
                var chunked_sets = chunkIntoSetsOf10(item.bucket_names);
                item.chunked_bucket_list = chunked_sets;
                total_buckets = total_buckets + chunked_sets.length
            });
            $('#total_records').text(total_buckets)
            $('#dd_loading').hide()
            $('#dd_progress_container').show()
            var success_bucket_count = 0;
            var error_bucket_count = 0;
            resulting_object.forEach(function (item) {
                item.chunked_bucket_list.forEach( async function(bucket_group) {
                    var sendBucketData = {
                        patient: parseInt(item.patient),
                        bucket_list: bucket_group
                    }
                    try{
                        await $.ajax({
                                    type: "POST",
                                    url: "/data/fetch-bucket-list",
                                    context: this,
                                    data: sendBucketData,
                                    success: function(bucket_data, status) {
                                        // console.log(item)
                                        // console.log(bucket_data)
                                        if(item["sensor_data"] === null || item["sensor_data"] === undefined){
                                            item["sensor_data"] = bucket_data;
                                            console.log(item["sensor_data"])
                                        }else{
                                            
                                            
                                            item["sensor_data"] = item["sensor_data"].concat(bucket_data)
                                            console.log(item["sensor_data"])
                                            
                                        }
                                        success_bucket_count = success_bucket_count + 1;
                                        
                                        //50 % of progress bar is set for data download, so multiply result % by 0.5
                                        var completed_percentage = Math.ceil((success_bucket_count + error_bucket_count) / total_buckets * 100 * 0.9)
                                        
                                        $('#dd_progress_bar').prop('aria-valuenow', completed_percentage)
                                        $('#dd_progress_bar').width('' + completed_percentage + '%');
                                        $('#current_record').text(success_bucket_count + error_bucket_count)
                                        if(completed_percentage ===90){
                                            processDataForExport(resulting_object,success_bucket_count,error_bucket_count,total_buckets)
                                        }
                                    },
                                    error: function(err){
                                        console.log(err)
                                        error_bucket_count = error_bucket_count + 1;
                                        
                                        var completed_percentage = Math.ceil((success_bucket_count + error_bucket_count) / total_buckets * 100 * 0.9)
                                        
                                        $('#dd_progress_bar').prop('aria-valuenow', completed_percentage)
                                        $('#dd_progress_bar').width('' + completed_percentage + '%');
                                        $('#current_record').text(success_bucket_count + error_bucket_count)
                                        if(completed_percentage ===90){
                                            
                                            processDataForExport(resulting_object,success_bucket_count,error_bucket_count,total_buckets)
                                            
                                        }

                                    }
                                });
                    }catch(error){
                        console.log(error)
                    }
                    
                    
                    
                    
                })
            });
            
        },
        error: function(err) {
            //trigger error
            console.log(err)
            $('#dd_loading').hide()
            $('#dd_error').show()
        }
    });
    
}


function toggleDownloadButton(){
    if($('#file_type_csv').is(':checked')){
        if(!$('#sensor_1').is(':checked') && !$('#sensor_2').is(':checked') && !$('#sensor_3').is(':checked') && !$('#sensor_4').is(':checked')  && !$('#sensor_5').is(':checked')){
            console.log("no sensors_selected")
            $('#dd_button').prop("disabled",true)
        }
        if($('#sensor_1').is(':checked') || $('#sensor_2').is(':checked') || $('#sensor_3').is(':checked') || $('#sensor_4').is(':checked') || $('#sensor_5').is(':checked')){
            console.log("one + sensor selected")
            $('#dd_button').prop("disabled",false)
        }
    }
}

function processDataForExport(data,success_bucket_count,error_bucket_count,total_buckets){
    data.forEach(function (item) {
        delete item["chunked_bucket_list"];
        delete item["bucket_names"]
    })
    if($('#file_type_json').is(':checked')){
        $('#dd_progress_bar').prop('aria-valuenow', 100)
        $('#dd_progress_bar').width('100%');
        var hiddenElement = document.createElement('a');
        hiddenElement.href = 'data:text/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(data))
        hiddenElement.target = '_blank';
        hiddenElement.download = 'data.json';
        hiddenElement.click();
        
    }else{
        //trigger progress bar

        //create csv header and store if a data type is to be downloaded into a bool or not (storeAdpd = true, storeAdxl = false, etc)
        
        var csv_content = 'patient,unix_timestamp,'
        if($('#sensor_1').is(':checked')){
            var storeAdxl = true;
            csv_content = csv_content + 'adxl_x,adxl_y,adxl_z,'
        }
        if($('#sensor_2').is(':checked')){
            var storeEda = true;
            csv_content = csv_content + 'eda_real_data,eda_imaginary_data,eda_impedance_img,eda_impedance_real,eda_real_and_img,eda_impedance_magnitude,eda_impedance_phase,eda_admittance_real,eda_admittance_img,eda_admittance_phase,'
        }
        if($('#sensor_3').is(':checked')){
            var storePpg = true;
            csv_content = csv_content + 'ppg_adpd_lib_state,ppg_confidence,ppg_hr,ppg_type,ppg_interval,'
        }
        if($('#sensor_4').is(':checked')){
            var storeTemperature= true;
            csv_content = csv_content + 'temp_skin_temperature,temp_impedance,'
        }
        if($('#sensor_5').is(':checked')){
            var storeSyncPpg= true;
            csv_content = csv_content + 'syncppg_ppg_data,syncppg_adxl_timestamp,syncppg_x,syncppg_y,syncppg_z,'
        }

        csv_content = csv_content + 'crisis_event\r\n'
        
        var hasData = false;
        //foreach user
        var total_data_to_process = data.length;
        var current_data_counter = 0
        data.forEach(function (item) {
        
            //store data into vars 
            var patient_sequence_number = item.patient
            var patient_crisis_events = item.crisis_events
            var sensor_collection = item.sensor_data
        
            //  read their crisis events
            patient_crisis_events.forEach(function (crisis_event, index, patient_crisis_events) {
                if(Date.parse(moment($('input[name="daterange"]').data('daterangepicker').startDate).utc().format("YYYY-MM-DD")) < crisis_event.min && 
                Date.parse(moment($('input[name="daterange"]').data('daterangepicker').endDate).utc().format("YYYY-MM-DD")) < crisis_event.max){
                }else{
                    patient_crisis_events.splice(index, 1)
                }
                
            })
            patient_crisis_events.sort(function(a, b) {
                return a.min - b.min;
            });

            if(patient_crisis_events.length > 0){
                var current_crisis_min = patient_crisis_events[0].min;
                var current_crisis_max = patient_crisis_events[0].max;
                var is_in_current_crisis = false;
                var current_crisis_name = patient_crisis_events[0].name;
                var hasCrisis = true;
            }else{
                var hasCrisis = false
            }


            // read their arrays of sensor collection
            // patient_sensor_collections.forEach(function(sensor_collection) {
                //foreach of the sensor data entries in the sensor collection arrays:

                sensor_collection.forEach(function(sensor_data) {
                    //add patient and ts to csv
                    csv_line = '' + patient_sequence_number + ',' + sensor_data.unix_timestamp + ','
                    var needStorage = false;
                    var unix_timestamp = sensor_data.unix_timestamp;
                    //check if sensor is supposed to be downloaded from bool control vars (storeAdpd = false, storeAdxl = true, etc)
                    if(storeAdxl){
                        //check if record has adxl data
                        if(!("adxl_x" in sensor_data)){
                            //if not add blank csv spaces
                            csv_line = csv_line + ',,,'
                        }else{
                            //if yes add all adxl values to csv
                            csv_line = csv_line + sensor_data.adxl_x + ',' 
                                                + sensor_data.adxl_y +  ',' 
                                                + sensor_data.adxl_z + ','
                            needStorage = true
                        }
                    }
                    if(storeEda){
                        if(!("eda_real_data" in sensor_data)){
                            csv_line = csv_line + ',,,,,,,,,,'
                        }else{
                            csv_line = csv_line + sensor_data.eda_real_data + ','
                                                + sensor_data.eda_imaginary_data +  ',' 
                                                + sensor_data.eda_impedance_img + ',' 
                                                + sensor_data.eda_impedance_real + ',' 
                                                + sensor_data.eda_real_and_img + ',' 
                                                + sensor_data.eda_impedance_magnitude + ',' 
                                                + sensor_data.eda_impedance_phase + ','
                                                + sensor_data.eda_admittance_real + ','
                                                + sensor_data.eda_admittance_img + ','
                                                + sensor_data.eda_admittance_phase + ','
                            needStorage = true
                        }
                        
                    }
                    if(storePpg){
                        if(!("ppg_adpd_lib_state" in sensor_data)){
                            csv_line = csv_line + ',,,,,'
                        }else{
                            csv_line = csv_line + sensor_data.ppg_adpd_lib_state + ',' 
                                                + sensor_data.ppg_confidence +  ',' 
                                                + sensor_data.ppg_hr + ','
                                                + sensor_data.ppg_type + ','
                                                + sensor_data.ppg_interval + ','
                            needStorage = true
                        }
                    }
                    if(storeTemperature){
                        if(!("temp_skin_temperature" in sensor_data)){
                            csv_line = csv_line + ',,'
                        }else{
                            csv_line = csv_line + sensor_data.temp_skin_temperature + ',' 
                                                + sensor_data.temp_impedance +  ',' 
                            needStorage = true
                        }
                    }
                    if(storeSyncPpg){
                        if(!("syncppg_ppg_data" in sensor_data)){
                            csv_line = csv_line + ',,,,,'
                        }else{
                            csv_line = csv_line + sensor_data.syncppg_ppg_data + ',' 
                                + sensor_data.syncppg_adxl_timestamp +  ',' 
                                + sensor_data.syncppg_x +  ',' 
                                + sensor_data.syncppg_y +  ',' 
                                + sensor_data.syncppg_z +  ',' 
                            needStorage = true
                        }
                    }
                    

                    if(hasCrisis){
                        //check if  it is happening at the same time as a crisis event
                        if(is_in_current_crisis){
                            //check if current crisis has ended
                            if(unix_timestamp >= current_crisis_max){
                                //change all control vars for next crisis event
                                is_in_current_crisis=false;
                                patient_crisis_events.splice(0, 1)
                                if(patient_crisis_events.length > 0){
                                    current_crisis_min = patient_crisis_events[0].min;
                                    current_crisis_max = patient_crisis_events[0].max;
                                    current_crisis_name = patient_crisis_events[0].name;
                                }else{
                                    hasCrisis = false
                                }
                                
                            }
                        }
                        //if it is not happening or just ended in this record
                        
                        if(!is_in_current_crisis){
                            patient_crisis_events.forEach(function (crisis_event, index, patient_crisis_events) {
                                //check if current_crisis_min > sensor timestamp 
                                if(unix_timestamp >= current_crisis_min){
                                    // check if current_crisis_max < sensor timestamp, if yes replace all control vars to make this current crisis
                                    if(unix_timestamp <= current_crisis_max){
                                        is_in_current_crisis = true;
                                        current_crisis_min = patient_crisis_events[index].min;
                                        current_crisis_max = patient_crisis_events[index].max;
                                        current_crisis_name = patient_crisis_events[index].name;
                                    }else{
                                        //if not remove this crisis from pool
                                        patient_crisis_events.splice(index, 1)
                                        if(patient_crisis_events.length === 0){
                                            hasCrisis = false
                                        }
                                    }
                                }
                            })
                        }
                        //if it still fits the crisis after validations, add crisis to csv line
                        if(is_in_current_crisis){
                            csv_line = csv_line + current_crisis_name
                            
                            
                        }
                    }

                    


                    if(needStorage){
                        //add csv line + \r\n to csv content
                        hasData = true
                        csv_content = csv_content + csv_line + '\r\n'
                    }else{
                        console.log("data line")
                        console.log(sensor_data)
                    }
                });
            })
            
                    
                        
                        
                        
            current_data_counter = current_data_counter + 1;

            //maximum is 50% so multiply percentage by 0.5
            current_processing_percentage = Math.ceil(current_data_counter / total_data_to_process * 100 * 0.1)
            $('#dd_progress_bar_process').prop('aria-valuenow', current_processing_percentage)
            $('#dd_progress_bar_process').animate({
                width: '' + current_processing_percentage + '%'
            }, 1000);
        // });
        if(hasData){
            var hiddenElement = document.createElement('a');
            hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv_content)
            hiddenElement.target = '_blank';
            hiddenElement.download = 'data.csv';
            hiddenElement.click();
        }
    }

    $('#success_total_lbl').text(success_bucket_count)
    $('#total_buckets_lbl').text(total_buckets)
    var success_rate = Math.ceil(success_bucket_count/total_buckets*100)
    fail_rate = 100-success_rate
    $('#success_rate_pb').prop('aria-valuenow', success_rate)
    $('#fail_rate_pb').prop('aria-valuenow', fail_rate)

    
    //set values for report
    $('#success_rate_pb').animate({
        width: '' + success_rate + '%'
    }, 1000);
    setTimeout(function(){
        $('#fail_rate_pb').animate({
            width: '' + fail_rate + '%'
        }, 1000);
    },1000)
    setTimeout(function(){ 
        $('#dd_progress_container').hide()
        $('#download_report').show()
     }, 2000);
    
    


    

}

function goToDownloadView(){
    $('#download_report').hide()
    $('#dd_content').show()
    $('#dd_progress_bar').prop('aria-valuenow', 0)
    $('#dd_progress_bar').width('0%');
}
function chunkIntoSetsOf10(bucket_list){
    var resulting_sets = [];
    for(var i=0; i< bucket_list.length; i = i + 10){
        //get chuck of 10 through slice method
        resulting_sets.push(bucket_list.slice(i, i+10));
    }
    return resulting_sets;
}
