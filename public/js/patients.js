var crisis_event_list = [];
var patient_id;
var needs_reset = false;
var new_med_form = '';
var professional_caret = 'down';
var teams_caret = 'down';
function getPatientInfo(patient_id){
    $('#dashboard_progress_bar').prop('aria-valuenow', 1)
    $('#dashboard_progress_bar').width('1%');
    $('#search_illustration').hide();
    $('#pl_error_container').hide()
    $('#no_sensor_data_charts_container').hide();
    $('#pat_desc_container').hide();
    $('#sensor_data_charts_container').show();
    $('#dd_progress_container').show();
    var today = new Date();
    var day = today.toUTCString();
    
    this.patient_id = patient_id;
    sendData = {
        p_id: patient_id,
        date_query: day
    };
    $.ajax({
        type: "GET",
        url: "/view-patient",
        context: this,
        data: sendData,
        success: function(data) {
            $('#pat_desc_container').html(data.entry_ui);
            this.crisis_event_list = data.crisis_event_list;
            
            if(data.average_bpm != null){
                $('#avg_bpm_value').text(data.average_bpm);
            }
            if(data.bucket_list.length > 0){
                $('#no_sensor_data_charts_container').hide();
                $('#sensor_data_charts_container').show();
                var chunked_sets = chunkIntoSetsOf10(data.bucket_list);
                var total_buckets = chunked_sets.length;
                var success_bucket_count = 0;
                var error_bucket_count = 0;
                console.log("fetching the following buckets", chunked_sets);

                chunked_sets.forEach( async function(bucket_group) {
                    var sendBucketData = {
                        patient: parseInt(patient_id),
                        bucket_list: bucket_group
                    }
                    try{
                        await $.ajax({
                                    type: "POST",
                                    url: "/data/fetch-bucket-list",
                                    context: this,
                                    data: sendBucketData,
                                    success: function(bucket_data, status) {
                                        if(data["sensor_data"] === null || data["sensor_data"] === undefined){
                                            data["sensor_data"] = bucket_data;
                                        }else{
                                            
                                            
                                            data["sensor_data"] = data["sensor_data"].concat(bucket_data)
                                            
                                        }
                                        console.log("final bucket has ",data["sensor_data"].length, "sensor entries")
                                        success_bucket_count = success_bucket_count + 1;
                                        
                                        //50 % of progress bar is set for data download, so multiply result % by 0.5
                                        var completed_percentage = Math.ceil((success_bucket_count + error_bucket_count) / total_buckets * 100 )
                                        
                                        $('#dashboard_progress_bar').prop('aria-valuenow', completed_percentage)
                                        $('#dashboard_progress_bar').width('' + completed_percentage + '%');
                                        if(completed_percentage ===100){
                                            console.log('success', success_bucket_count)
                                            console.log('error', error_bucket_count)
                                            //finish loading and draw charts
                                            drawChartsv2(data["sensor_data"],'dash')
                                        }
                                    },
                                    error: function(err){
                                        console.log(err)
                                        error_bucket_count = error_bucket_count + 1;
                                        
                                        var completed_percentage = Math.ceil((success_bucket_count + error_bucket_count) / total_buckets * 100 )
                                        
                                        $('#dashboard_progress_bar').prop('aria-valuenow', completed_percentage)
                                        $('#dashboard_progress_bar').width('' + completed_percentage + '%');
                                        if(completed_percentage ===100){
                                            console.log('success', success_bucket_count)
                                            console.log('error', error_bucket_count)
                                            //finish loading and draw charts
                                            drawChartsv2(data["sensor_data"],'dash')
                                            
                                            
                                        }

                                    }
                                });
                    }catch(error){
                        console.log(error)
                    }
                    
                    
                    
                    
                })
            }else{
                $('#dashboard_progress_bar').prop('aria-valuenow', 100)
                $('#dashboard_progress_bar').width('100%');
                drawChartsv2(undefined,'dash')
            }
            
            


            //user crisis events charts
            var c_e_l_24h = data.c_e_l_24h;
            var c_e_l_7d = data.c_e_l_7d;
            var c_e_l_30d = data.c_e_l_30d;
            var c_e_l_365d = data.c_e_l_365d;
            //total without last year
            var c_e_total_wo_l_y = data.c_e_total_wo_l_y;
            if(c_e_l_24h + c_e_l_7d + c_e_l_30d + c_e_l_365d + c_e_total_wo_l_y == 0){
                $('#user_crisis_pie_chart_container').hide()
            }else{
                //doughnut chart data
                //define 5 colors since 5 labels are defined in frontend
                var background_colors = [
                    "#f74f3d",
                    "#F4CA64",
                    "#38C172",
                    "#63A2D8",
                    "#203D54"
                ];
                for(var i in background_colors){
                    var legend_id = parseInt(i) + 1;
                    $('#u_c_e_legend_'+legend_id).css("background-color", background_colors[i]);
                }
                var crisis_event_over_time_data = {
                    datasets: [{
                        data:[
                            c_e_l_24h,
                            c_e_l_7d,
                            c_e_l_30d,
                            c_e_l_365d,
                            c_e_total_wo_l_y
                        ],
                        backgroundColor: background_colors,
                    }],
                    labels: [
                        'last 24h',
                        'last 7 days',
                        'last 30 days',
                        'last year',
                        'other'
                    ]
                }
                drawDoughnutChart('u_c_e_vs_time_intervals_chart',crisis_event_over_time_data)

                
            }

           

            $('#patient_professionals_caret').on('click', function(){
                if(professional_caret == 'down'){
                    $('#patient_professionals_caret').removeClass('fa-caret-down')
                    $('#patient_professionals_caret').addClass('fa-caret-up')
                    professional_caret = 'up';
                }else{
                    $('#patient_professionals_caret').removeClass('fa-caret-up')
                    $('#patient_professionals_caret').addClass('fa-caret-down')
                    professional_caret = 'down';
                }
            });

            $('#patient_teams_caret').on('click', function(){
                if(professional_caret == 'down'){
                    $('#patient_teams_caret').removeClass('fa-caret-down')
                    $('#patient_teams_caret').addClass('fa-caret-up')
                    professional_caret = 'up';
                }else{
                    $('#patient_teams_caret').removeClass('fa-caret-up')
                    $('#patient_teams_caret').addClass('fa-caret-down')
                    professional_caret = 'down';
                }
            });

            //calendar demo code
            var now = new Date();
            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var date = now.getDate();


            var data = [{
                date: year + '-' + month + '-' + date,
                value: 'hello'
            }
        ];

        // inline
        var $ca = $('#med_calendar').calendar({
            // width and height in pixels
            width: 250,
            height: 300,

            // z-inde property
            zIndex: 1,

            // selector or element
            trigger: null,

            // custom CSS class
            customClass: '',

            // date or month
            view: 'date',

            // current date  
            date: new Date(),

            // date format
            format: 'yyyy/mm/dd',

            // start of week
            startWeek: 0,

            // day of the week
            weekArray: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

            // month
            monthArray: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],

            // date range
            // [new Date(), null] or ['2015/11/23']
            selectedRang: null,

            // custom events
            data: null,

            // next / prev signs
            prev: '&lt;',
            next: '&gt;',

            // callbacks
            viewChange: $.noop,
            onSelected: function(view, date, value) {
                $('#medication_schedule_container').hide()
                $('#med_schedule_loading').show();
                day = date.getDate();
                if(day<10){
                    day = '0' + day;
                }
                month = date.getMonth() + 1;
                if(month<10){
                    month = '0' + month;
                }
                dateToSend = "" + day + "/" + month + "/" + date.getFullYear();
                sendData = {
                    p_id: patient_id,
                    date: dateToSend
                };
            
                $.ajax({
                    type: "GET",
                    url: "/medication/patient/date",
                    context: this,
                    data: sendData,
                    success: function(data) {
                        $('#medication_schedule_container').html(data);
                        $('#med_schedule_loading').hide();
                        $('#medication_schedule_container').show()
                    },
                    error: function(err) {
                        
                        console.log('[ERROR ' + err.status + "]: " + err.responseText);
                    }
                });
                
            },
            onMouseenter: $.noop,
            onClose: $.noop
                        
        });
        

            
            
            
            $('#daterangepicker').daterangepicker({
                "timePicker": true,
                "maxSpan": {
                    "days": 7
                },
                
                "startDate": moment().startOf('hour').add(-24, 'hour'),
                "endDate": moment().startOf('hour'),
                "opens": "left",
                "locale": {
                    "format": "YYYY-MM-DD H:mm"
                },
                
            });
              
            
            
        },
        error: function(err) {
            $('#dd_progress_container').hide();
            $('#pat_desc_container').hide();
            $('#pl_error_container').show()
        }
    });

    
    
}



function redrawChartsForPatDesc(){
    $('#dashboard_progress_bar').prop('aria-valuenow', 1)
    $('#dashboard_progress_bar').width('1%');
    $('#search_illustration').hide();
    $('#pl_error_container').hide()
    $('#pat_desc_container').hide();
    $('#dd_progress_container').show();

     //need to transform the log above into the start_date and end_date in sendData below!
    
    var end_date = moment($('input[name="daterange"]').data('daterangepicker').endDate).utc().format("DD/MM/YYYY HH:mm");
    
    var start_date = moment($('input[name="daterange"]').data('daterangepicker').startDate).utc().format("DD/MM/YYYY HH:mm");
    
    sendData = {
        p_id: patient_id,
        start_date: start_date,
        end_date: end_date
    };

    $.ajax({
        type: "GET",
        url: "/view-patient/chart-filter",
        context: this,
        data: sendData,
        success: function(data) {
            console.log(data)
            if(data.bucket_list.length > 0){
                $('#no_sensor_data_charts_container').hide();
                $('#sensor_data_charts_container').show();

                var chunked_sets = chunkIntoSetsOf10(data.bucket_list);
                var total_buckets = chunked_sets.length;
                var success_bucket_count = 0;
                var error_bucket_count = 0;

                chunked_sets.forEach( async function(bucket_group) {
                    var sendBucketData = {
                        patient: parseInt(patient_id),
                        bucket_list: bucket_group
                    }
                    try{
                        await $.ajax({
                                    type: "POST",
                                    url: "/data/fetch-bucket-list",
                                    context: this,
                                    data: sendBucketData,
                                    success: function(bucket_data, status) {
                                        if(data["sensor_data"] === null || data["sensor_data"] === undefined){
                                            data["sensor_data"] = bucket_data;
                                        }else{
                                            
                                            
                                            data["sensor_data"] = data["sensor_data"].concat(bucket_data)
                                            
                                        }

                                        
                                        success_bucket_count = success_bucket_count + 1;
                                        
                                        //50 % of progress bar is set for data download, so multiply result % by 0.5
                                        var completed_percentage = Math.ceil((success_bucket_count + error_bucket_count) / total_buckets * 100 )
                                        
                                        $('#dashboard_progress_bar').prop('aria-valuenow', completed_percentage)
                                        $('#dashboard_progress_bar').width('' + completed_percentage + '%');
                                        if(completed_percentage ===100){
                                            console.log('success', success_bucket_count)
                                            console.log('error', error_bucket_count)
                                            //finish loading and draw charts
                                            drawChartsv2(data["sensor_data"],'dash')
                                        }
                                    },
                                    error: function(err){
                                        console.log(err)
                                        error_bucket_count = error_bucket_count + 1;
                                        
                                        var completed_percentage = Math.ceil((success_bucket_count + error_bucket_count) / total_buckets * 100 )
                                        
                                        $('#dashboard_progress_bar').prop('aria-valuenow', completed_percentage)
                                        $('#dashboard_progress_bar').width('' + completed_percentage + '%');
                                        if(completed_percentage ===100){
                                            console.log('success', success_bucket_count)
                                            console.log('error', error_bucket_count)
                                            //finish loading and draw charts
                                            drawChartsv2(data["sensor_data"],'dash')
                                            
                                            
                                        }

                                    }
                                });
                    }catch(error){
                        console.log(error)
                    }
                    
                    
                    
                    
                })
            }else{
                $('#dashboard_progress_bar').prop('aria-valuenow', 100)
                $('#dashboard_progress_bar').width('100%');
                drawChartsv2(undefined,'dash')
            }
            
            
        },
        error: function(err) {
            $('#dd_progress_container').hide();
            $('#pat_desc_container').hide();
            $('#pl_error_container').show()
        }
    });
    
}





var global_page_id;

function goToCrisisEvent(page_id){
    $('#nav-crisis-report-tab').tab('show')
    //open crisis event default page
    $('#crisis_list_container').hide()
    $('#list_loading_container').show()
    var patient_id = this.patient_id;
    global_page_id = page_id;
    //go to server get data for 1h before and after crisis
    sendData = {
        p_id: patient_id,
        page_nr: page_id
    };
    $.ajax({
        type: "GET",
        url: "/crisis-event-report",
        context: this,
        data: sendData,
        success: function(data) {
            $('#crisis_list_container').html(data.entry_ui);
            if(data.bucket_list.length > 0) {
                //fetch data in chunked buckets and draw crisis_report charts
                var chunked_sets = chunkIntoSetsOf10(data.bucket_list);
                var total_buckets = chunked_sets.length;
                var success_bucket_count = 0;
                var error_bucket_count = 0;
                
                $('#ce_sensor_data_container').hide()
                $('#ce_no_sensor_data').hide()
                $('#crisis_report_progress_container').show()

                chunked_sets.forEach( async function(bucket_group) {
                    var sendBucketData = {
                        patient: parseInt(patient_id),
                        bucket_list: bucket_group
                    }
                    try{
                        await $.ajax({
                                    type: "POST",
                                    url: "/data/fetch-bucket-list",
                                    context: this,
                                    data: sendBucketData,
                                    success: function(bucket_data, status) {
                                        if(data["sensor_data"] === null || data["sensor_data"] === undefined){
                                            data["sensor_data"] = bucket_data;
                                        }else{
                                            
                                            
                                            data["sensor_data"] = data["sensor_data"].concat(bucket_data)
                                            
                                        }
                                        
                                        success_bucket_count = success_bucket_count + 1;
                                        
                                        //50 % of progress bar is set for data download, so multiply result % by 0.5
                                        var completed_percentage = Math.ceil((success_bucket_count + error_bucket_count) / total_buckets * 100 )
                                        
                                        $('#crisis_report_progress_bar').prop('aria-valuenow', completed_percentage)
                                        $('#crisis_report_progress_bar').width('' + completed_percentage + '%');
                                        if(completed_percentage ===100){
                                            
                                            //finish loading and draw charts
                                            drawChartsv2(data["sensor_data"],'crisis_report')
                                            $('#crisis_report_progress_container').hide()
                                            $('#ce_sensor_data_container').show()
                                            
                                        }
                                    },
                                    error: function(err){
                                        console.log(err)
                                        error_bucket_count = error_bucket_count + 1;
                                        
                                        var completed_percentage = Math.ceil((success_bucket_count + error_bucket_count) / total_buckets * 100 )
                                        
                                        $('#crisis_report_progress_bar').prop('aria-valuenow', completed_percentage)
                                        $('#crisis_report_progress_bar').width('' + completed_percentage + '%');
                                        if(completed_percentage ===100){
                                            
                                            //finish loading and draw charts
                                            drawChartsv2(data["sensor_data"],'crisis_report')
                                            $('#crisis_report_progress_container').hide()
                                            $('#ce_sensor_data_container').show()
                                            
                                            
                                        }

                                    }
                                });
                    }catch(error){
                        console.log(error)
                    }
                    
                    
                    
                    
                })
                
            }else{
                $('#crisis_report_progress_bar').prop('aria-valuenow', 100)
                $('#crisis_report_progress_bar').width('100%');
                drawChartsv2(undefined,'crisis_report')
                
                $('#ce_sensor_data_container').show()
                
            }
            $('#list_loading_container').hide()
            $('#crisis_list_container').show();
            
            
        },
        error: function(err) {
            $('#list_loading_container').hide()
            $('#uc_error_container').show()
        }
        //return content of div in component user_crisis_event_list_page
    });
    
}



function showNoUserCrisisEvents() {
    $('#crisis_list_container').hide();
    $('#crisis_list_no_data').show();
}



function removeInvalidFeedbacksMedForm(){
    $('#med_name').removeClass('is-invalid');
    $('#med_dosage').removeClass('is-invalid');
    $('#med_pills_in_morning').removeClass('is-invalid');
    $('#med_pills_at_lunch').removeClass('is-invalid');
    $('#med_pills_at_night').removeClass('is-invalid');
    $('#med_treatment_duration').removeClass('is-invalid');
    $('#med_treatment_duration_error').hide();
    var takings_list = document.getElementsByClassName('med-row-entry');
    var counter1;
    for(counter1 = 0; counter1 < takings_list.length; counter1 ++){
        var input_vals = takings_list[counter1].getElementsByClassName('form-control')
        input_vals[0].classList.remove("is-invalid");
        input_vals[1].classList.remove("is-invalid");
        input_vals[2].classList.remove("is-invalid");
    }
}


function removeInvalidFeedbacksCrisisForm(){
    $('#crisis_id').removeClass('is-invalid');
    $('#crisis_duration').removeClass('is-invalid');
    $('#crisis_year').removeClass('is-invalid');
    $('#crisis_month').removeClass('is-invalid');
    $('#crisis_day').removeClass('is-invalid');
    $('#crisis_hour').removeClass('is-invalid');
    $('#crisis_min').removeClass('is-invalid');
    $('#crisis_notes').removeClass('is-invalid');
    
}

function addCrisisEvent(){
    removeInvalidFeedbacksCrisisForm()

    //initialize date object. if date is invalid, date.getTime() ==  NaN
    var day = $('#crisis_day').val();
    if(day.length == 1){
        day = '0'+ day;
    }
    var month = $('#crisis_month').val();
    if(month.length == 1){
        month = '0'+ month;
    }
    
    
    //check if all fields are filled and if date is valid
    if($('#crisis_year').val() == '' || $('#crisis_year').val() == null ||  
        $('#crisis_month').val() == '' || $('#crisis_month').val() == null ||
        $('#crisis_day').val() == '' || $('#crisis_day').val() == null ||
        validatedate('' + day + '/' + month + '/' +$('#crisis_year').val()) == false)
        {
            $('#crisis_year').addClass('is-invalid');
            $('#crisis_month').addClass('is-invalid');
            $('#crisis_day').addClass('is-invalid');
            return false;
        }
    if($('#crisis_hour').val() == '' || $('#crisis_hour').val()<0 || $('#crisis_hour').val()>23){
        $('#crisis_hour').addClass('is-invalid');
        return false;
    }
    if($('#crisis_min').val() == '' || $('#crisis_min').val()<0 || $('#crisis_min').val()>59){
        $('#crisis_min').addClass('is-invalid');
        return false;
    }
    if($('#crisis_duration').val() <= 0 || $('#crisis_duration').val() == ''){
        $('#crisis_duration').addClass('is-invalid');
        return false;
    }
    // was changed to optional, remove comment if it is mandatory again
    // if($('#crisis_notes').val() == ''){
    //     $('#crisis_notes').addClass('is-invalid');
    //     return false;
    // }
    $('#add_crisis_form').hide()
    $('#add_crisis_loading').show()
    sendData = {
        pat_id: this.patient_id,
        crisis_id: $('#crisis_id').val() ,
        crisis_duration: $('#crisis_duration').val() ,
        crisis_date: '' + $('#crisis_year').val() + '-' + month + '-' + day,
        crisis_hour: $('#crisis_hour').val() ,
        crisis_min: $('#crisis_min').val() ,
        crisis_notes: $('#crisis_notes').val() ,
    };
    $.ajax({
        type: "POST",
        url: "/new_crisis_event",
        context: this,
        data: sendData,
        success: function(data) {
            $('#add_crisis_loading').hide()
            $('#add_crisis_success').show()
            $('#crisis_save_btn').hide()
            $('#crisis_close_btn').show()
            $('#new_crisis_event_form').val(data.reset_form_html);
            getPatientInfo($('#searchbar').val())
        },
        error: function(err) {
            $('#add_crisis_loading').hide()
            $('#add_crisis_error').show()
            console.log(err)
            $('#new_crisis_event_form').val(data.reset_form_html);
        }
    });
}

function showMedOptions(){
    $('#arrow_down_med_options').hide()
    $('#arrow_up_med_options').show()
}

function hideMedOptions() {
    $('#arrow_up_med_options').hide()
    $('#arrow_down_med_options').show()
}

function addMedication(){
    removeInvalidFeedbacksMedForm()
    if($('#med_name').val() == ''){
        $('#med_name').addClass('is-invalid');
        return false;
    }
    if($('#med_dosage').val() <= 0){
        $('#med_dosage').addClass('is-invalid');
        return false;
    }

    sendData = {
        medication_name: $('#med_name').val() ,
        medication_dosage: $('#med_dosage').val() ,
        medication_type: $('#med_type').val() ,
        patient_id: this.patient_id,
        periodicity: parseInt($('#med_periodicity').text()),
        
    };
        var takings_list = document.getElementsByClassName('med-row-entry');
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
        if(document.getElementById('undefined_treatment_duration').checked) {
            sendData["treatment_duration"] =  -1 ;
        }else if(document.getElementById('defined_treatment_duration').checked) {
            if($('#med_treatment_duration').val() <= 0){
                $('#med_treatment_duration').addClass('is-invalid');
                return false;
            }
            sendData["treatment_duration"] = $('#med_treatment_duration').val() 
        }else{
            $('#med_treatment_duration_error').show();
            return false;   
        }
        $('#add_med_form').hide()
        $('#add_med_loading').show()
    $.ajax({
        type: "POST",
        url: "/new_med_schedule",
        context: this,
        data: sendData,
        success: function(data) {
            $('#add_med_loading').hide()
            $('#add_med_success').show()
            $('#med_save_btn').hide()
            $('#med_close_btn').show()
            $('#new_med_form').val(data.reset_form_html);
            
        },
        error: function(err) {
            $('#new_med_form').val(data.reset_form_html);
            $('#add_med_loading').hide()
            $('#add_med_error').show()
            console.log(err)
            
        }
    });


}

//clear modal for medication
$('#addMedModal').on('hidden.bs.modal', function (e) {
    $('#add_med_success').hide()
    $('#add_med_error').hide()
    if($('#new_med_form').val() != ''){
        $('#resetable_med_form').html($('#new_med_form').val());
        $('#med_save_btn').show()
    }
    $('#defined_treatment_duration').on('change',function(){
        $('#treatment_duration_collapse').collapse('show');
    })
    
    $('#undefined_treatment_duration').on('change',function(){
        $('#treatment_duration_collapse').collapse('hide');
    })
    //update med schedule
    $('#medication_schedule_container').hide()
    $('#med_schedule_loading').show();
    if($('#med_calendar .selected')[0]){
        $('#med_calendar .selected').click()
        
    }else{
        $('#med_calendar .now').click()
    }
})

//clear modal for user_crisis
$('#addCrisisModal').on('hidden.bs.modal', function (e) {
    $('#add_crisis_success').hide()
    $('#add_crisis_error').hide()
    if($('#new_crisis_event_form').val() != ''){
        $('#resetable_crisis_event_form').html($('#new_crisis_event_form').val());
        $('#crisis_save_btn').show()
    }
    $('#add_crisis_form').show()
})


//med schedule navigation

function navigateMedScheduleTo(page){
    removeActiveFromAllPages()
    switch(page){
        case 1:
            $('#container_0').show()
            $('#page_item_1').addClass('active')
            break;
        case 2:
            $('#container_1').show()
            $('#page_item_2').addClass('active')
            break;
        case 3:
            $('#container_2').show()
            $('#page_item_3').addClass('active')
            break;
        case 4:
            $('#container_3').show()
            $('#page_item_4').addClass('active')
            break;
        case 5:
            $('#container_4').show()
            $('#page_item_5').addClass('active')
            break;
        case 6:
            $('#container_5').show()
            $('#page_item_6').addClass('active')
            break;
        default:
            console.log("error");
    }
}

function removeActiveFromAllPages(){
    $('#container_0').hide()
    $('#container_1').hide()
    $('#container_2').hide()
    $('#container_3').hide()
    $('#container_4').hide()
    $('#container_5').hide()
    $('#page_item_1').removeClass('active')
    $('#page_item_2').removeClass('active')
    $('#page_item_3').removeClass('active')
    $('#page_item_4').removeClass('active')
    $('#page_item_5').removeClass('active')
    $('#page_item_6').removeClass('active')
}

//periodicity toggling
function addToPeriodicity(){
    $('#med_periodicity').text(parseInt($('#med_periodicity').text()) + 1 );
}

function subtractFromPeriodicity(){
    if(parseInt($('#med_periodicity').text())>1){
        $('#med_periodicity').text(parseInt($('#med_periodicity').text()) - 1) ;
    }
}

//number of takings toggle
function addToNumberOfTakings(){
    $('#med_number_of_takings').text(parseInt($('#med_number_of_takings').text()) + 1 );
    var html_to_add = '<div class="row med-row-entry">'+
        '<div class="col-12 col-md-6 text-left">'+
            // {{-- number of pills in the taking--}}
            '<label for="med_taking_amount"> '+ $('#amount_to_take_lbl_val').val()+' </label>'+
            '<input type="number" min="0" value="0" class="form-control " name="med_taking_amount" id="med_taking_amount" >'+
        '</div>'+
        '<div class="col-12 col-md-6 text-left">'+
            // {{-- time for first taking--}}
            '<div class="row">'+
                '<div class="col-6">'+
                    '<label for="med_taking_hours">'+ $('#hours_to_take_lbl_val').val() + '</label>'+
                    '<input type="number" min="0" val="0" max="23" class="form-control " name="med_taking_hours" id="med_taking_hours" >'+  
                '</div>'+
                '<div class="col-6">'+
                    '<label for="med_taking_mins">'+ $('#minutes_to_take_lbl_val').val()  +'</label>'+
                    '<input type="number" min="0" val="0" max="23" class="form-control " name="med_taking_mins" id="med_taking_mins" >  '+
                '</div>'+
            '</div>'+
        '</div>'+
    '</div>'
    $('#med_taking_entries').html( $('#med_taking_entries').html( ) + html_to_add);


}
function subtractFromNumberOfTakings(){
    if(parseInt($('#med_number_of_takings').text())>1){
        $('#med_number_of_takings').text(parseInt($('#med_number_of_takings').text()) - 1) ;
        var takings_list = document.getElementsByClassName('med-row-entry');
        var subtracted_html = ''
        for (var counter in takings_list) {
            if(counter == takings_list.length - 1){
                break;
            }
            subtracted_html = subtracted_html +'<div class="row med-row-entry">'+ takings_list[counter].innerHTML + '</div>';
        }
        $('#med_taking_entries').html(subtracted_html);

    }
    
}



$('#defined_treatment_duration').on('change',function(){
    $('#treatment_duration_collapse').collapse('show');
})

$('#undefined_treatment_duration').on('change',function(){
    $('#treatment_duration_collapse').collapse('hide');
})
// validates if string text is is format dd/mm/yyyy
function validatedate(inputText)
  {
    var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    // Match the date format through regular expression
    if(inputText.match(dateformat)){
        //Test which seperator is used '/' or '-'
        var opera1 = inputText.split('/');
        var opera2 = inputText.split('-');
        lopera1 = opera1.length;
        lopera2 = opera2.length;
        // Extract the string into month, date and year
        if (lopera1>1){
            var pdate = inputText.split('/');
        }
        else if (lopera2>1){
            var pdate = inputText.split('-');
        }
        var dd = parseInt(pdate[0]);
        var mm  = parseInt(pdate[1]);
        var yy = parseInt(pdate[2]);
        // Create list of days of a month [assume there is no leap year by default]
        var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
        if (mm==1 || mm>2){
            if (dd>ListofDays[mm-1]){
                return false;
            }
        }
        if (mm==2){
            var lyear = false;
            if ( (!(yy % 4) && yy % 100) || !(yy % 400)) {
                lyear = true;
            }
            if ((lyear==false) && (dd>=29)){
                return false;
            }
            if ((lyear==true) && (dd>29)){
                return false;
            }
        }
        return true;
    }
    else{
        return false;
    }
  }
 

  function chunkIntoSetsOf10(bucket_list){
    var resulting_sets = [];
    for(var i=0; i< bucket_list.length; i = i + 10){
        //get chuck of 10 through slice method
        resulting_sets.push(bucket_list.slice(i, i+10));
    }
    return resulting_sets;
}

function drawChartsv2(data,location_prefix){
    var connect_gaps_between_seconds = 3000; //in milliseconds
    temperature_chart_data = []
    var lastTempTs = 0;

    heart_rate_chart_data = []
    var lastHrTs = 0

    //USES SYNC PPG!
    ppg_chart_data = []
    var lastPpgTs = 0

    eda_chart_data = []
    var lastEdaTs = 0

    adxl_x_chart_data = []
    adxl_y_chart_data = []
    adxl_z_chart_data = []
    var lastAdxlTs = 0
    //TODO: if no data then return a no data page
    if(data === undefined) {
        if(location_prefix == 'dash'){
            $('#dd_progress_container').hide();
            $('#sensor_data_charts_container').hide();    
            $('#pat_desc_container').show();
            $('#no_sensor_data_charts_container').show();
        }else if(location_prefix == 'crisis_report'){
            $('#ce_sensor_data_container').hide();    
            $('#ce_no_sensor_data').show();
            
        }
        
        
    }else{
        var tc = 0 ;
        console.log(data)
        data.forEach( function(sensor_record) {
            
            if(sensor_record != null){
                tc = tc +1;
                if(("temp_skin_temperature" in sensor_record)){
                    //if 2 points are more than X seconds apart
                    if(parseInt(sensor_record["unix_timestamp"]) - lastTempTs > connect_gaps_between_seconds){
                        if(lastTempTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            temperature_chart_data.push( {x: new Date(lastTempTs + 1),y: null})
                        }
                        
                    }else if(parseInt(sensor_record["unix_timestamp"]) - lastTempTs < -connect_gaps_between_seconds){
                        if(lastTempTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            temperature_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"]) + 1),y: null})
                        }
                        
                    }
                    lastTempTs = parseInt(sensor_record["unix_timestamp"])
                    temperature_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"])),y: parseFloat(sensor_record["temp_skin_temperature"])})
                } 
                if(("ppg_hr" in sensor_record)){
                    //if 2 points are more than X seconds apart
                    if(parseInt(sensor_record["unix_timestamp"]) - lastHrTs > connect_gaps_between_seconds){
                        if(lastHrTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            heart_rate_chart_data.push( {x: new Date(lastHrTs + 1),y: null})
                        }
                    }else if(parseInt(sensor_record["unix_timestamp"]) - lastHrTs < -connect_gaps_between_seconds ){
                        if(lastHrTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            heart_rate_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"]) + 1),y: null})
                        }
                    }
                    lastHrTs = parseInt(sensor_record["unix_timestamp"])
                    heart_rate_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"])),y: parseFloat(sensor_record["ppg_hr"])})
                } 
                if(("syncppg_ppg_data" in sensor_record)){
                    //if 2 points are more than X seconds apart
                    if(parseInt(sensor_record["unix_timestamp"]) - lastPpgTs > connect_gaps_between_seconds  ){
                        if(lastPpgTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            ppg_chart_data.push( {x: new Date(lastPpgTs + 1),y: null})
                        }
                    }else if(parseInt(sensor_record["unix_timestamp"]) - lastPpgTs < -connect_gaps_between_seconds){
                        if(lastPpgTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            ppg_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"]) + 1),y: null})
                        }
                    }
                    lastPpgTs = parseInt(sensor_record["unix_timestamp"])
                    ppg_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"])),y: (parseFloat(sensor_record["syncppg_ppg_data"]) / 1000)})
                } 
        
                if(("eda_admittance_real" in sensor_record)){
                    //if 2 points are more than X seconds apart
                    if(parseInt(sensor_record["unix_timestamp"]) - lastEdaTs > connect_gaps_between_seconds){
                        if(lastEdaTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            eda_chart_data.push( {x: new Date(lastEdaTs + 1),y: null})
                        } 
                    }else if(parseInt(sensor_record["unix_timestamp"]) - lastEdaTs < -connect_gaps_between_seconds){
                        if(lastEdaTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            eda_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"]) + 1),y: null})
                        } 
                    }
                    lastEdaTs = parseInt(sensor_record["unix_timestamp"])
                    eda_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"])),y: (parseFloat(sensor_record["eda_admittance_real"]) * 1000000)})
                } 
                if(("adxl_x" in sensor_record)){
                    //if 2 points are more than X seconds apart
                    if(parseInt(sensor_record["unix_timestamp"]) - lastAdxlTs > connect_gaps_between_seconds){
                        if(lastAdxlTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            adxl_x_chart_data.push( {x: new Date(lastAdxlTs + 1),y: null})
                            adxl_y_chart_data.push( {x: new Date(lastAdxlTs + 1),y: null})
                            adxl_z_chart_data.push( {x: new Date(lastAdxlTs + 1),y: null})
                        }
                    }else if(parseInt(sensor_record["unix_timestamp"]) - lastAdxlTs < -connect_gaps_between_seconds ){
                        if(lastAdxlTs !== 0) {
                            //add null to temperature_chart_data to break the line which connects points in charts
                            adxl_x_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"]) + 1),y: null})
                            adxl_y_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"]) + 1),y: null})
                            adxl_z_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"]) + 1),y: null})
                        }
                    }
                    lastAdxlTs = parseInt(sensor_record["unix_timestamp"])
                    adxl_x_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"])),y: parseFloat(sensor_record["adxl_x"])})
                    adxl_y_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"])),y: parseFloat(sensor_record["adxl_y"])})
                    adxl_z_chart_data.push( {x: new Date(parseInt(sensor_record["unix_timestamp"])),y: parseFloat(sensor_record["adxl_z"])})
                }
            }else{
                tc = tc + 1;
                console.log("a sensor record is null!", tc)
            }
             
        });
        
        
        var temperature_chart = new CanvasJS.Chart(location_prefix + "_temperature_chart_container", {
            title: {
                text: "Skin Temperature",
                fontFamily: "sans-serif",
                fontSize: 20,
                fontColor: "#2368A2"
            },
            toolTip:{
                shared: true
            }, 
            height: 300,
            animationEnabled: true,
            exportEnabled: true,
            axisX: {
                crosshair: {
                    enabled: true 
                },
            },
            axisY: {
                title: "Temperature (ºC)",
                titleFontFamily: "Arial"
            },
            data: [
            {
                color: "#3185c9",
                xValueFormatString: "YYYY-MM-DD HH:mm:ss.fff",
                name: "Skin Temperature (ºC)",
                type: "line",
                dataPoints: temperature_chart_data
                
            }
            ]
        });
    
        var heart_rate_chart = new CanvasJS.Chart(location_prefix + "_heart_rate_chart_container", {
            title: {
                text: "Cardiac Monitoring",
                fontFamily: "sans-serif",
                fontSize: 20,
                fontColor: "#2368A2"
            },
            toolTip:{
                shared: true
            }, 
            height: 300,
            animationEnabled: true,
            exportEnabled: true,
            axisX: {
                crosshair: {
                    enabled: true 
                },
            },
            axisY: {
                title: "Heart Rate (bpm)",
                titleFontFamily: "Arial"
            },
            data: [
            {
                color: "#3185c9",
                xValueFormatString: "YYYY-MM-DD HH:mm:ss.fff",
                name: "Heart Rate (Bpm)",
                type: "line", 
                dataPoints: heart_rate_chart_data
                
            }
            ]
        });
        
    
        var ppg_chart = new CanvasJS.Chart(location_prefix + "_ppg_chart_container", {
            title: {
                text: "Photoplethysmography",
                fontFamily: "sans-serif",
                fontSize: 20,
                fontColor: "#2368A2"
            },
            toolTip:{
                shared: true
            }, 
            height: 300,
            animationEnabled: true,
            exportEnabled: true,
            // zoomEnabled: true, 
            axisX: {
                crosshair: {
                    enabled: true 
                },
            },
            axisY: {
                title: "Amplitude x1000 (a.u.)",
                titleFontFamily: "Arial"
            },
            data: [
            {
                color: "#3185c9",
                xValueFormatString: "YYYY-MM-DD HH:mm:ss.fff",
                name: "Amplitude (a.u.)",
                type: "line", 
                dataPoints: ppg_chart_data
                
            }
            ]
        });
    
    
        var eda_chart = new CanvasJS.Chart(location_prefix + "_eda_chart_container", {
            title: {
                text: "Electrodermal Activity",
                fontFamily: "sans-serif",
                fontSize: 20,
                fontColor: "#2368A2"
            },
            toolTip:{
                shared: true
            }, 
            height: 300,
            animationEnabled: true,
            exportEnabled: true,
            // zoomEnabled: true, 
            axisX: {
                crosshair: {
                    enabled: true 
                },
            },
            axisY: {
                title: "Skin Conductance (µS)",
                titleFontFamily: "Arial"
            },
            data: [
            {
                color: "#3185c9",
                xValueFormatString: "YYYY-MM-DD HH:mm:ss.fff",
                name: "Skin Conductance (µS)",
                type: "line",
                dataPoints: eda_chart_data
                
            }
            ]
        });
        
    
        var adxl_chart = new CanvasJS.Chart(location_prefix + "_adxl_chart_container", {
            title: {
                text: "Motion/ Activity",
                fontFamily: "sans-serif",
                fontSize: 20,
                fontColor: "#2368A2"
            },
            toolTip:{
                shared: true
            }, 
            height: 300,
            animationEnabled: true,
            exportEnabled: true,
            // zoomEnabled: true, 
            axisX: {
                crosshair: {
                    enabled: true 
                },
            },
            axisY: {
                title: "Accelerometer (mg)",
                titleFontFamily: "Arial"
            },
            data: [
            {
                color: "#3185c9",
                xValueFormatString: "YYYY-MM-DD HH:mm:ss.fff",
                name: "X",
                type: "line",
                dataPoints: adxl_x_chart_data
                
            },
            {
                color: "#B82020",
                xValueFormatString: "YYYY-MM-DD HH:mm:ss.fff",
                name: "Y",
                type: "line",
                dataPoints: adxl_y_chart_data
                
            },
            {
                color: "#F4CA64",
                xValueFormatString: "YYYY-MM-DD HH:mm:ss.fff",
                name: "Z",
                type: "line",
                dataPoints: adxl_z_chart_data
                
            }
    
            ]
    
        });
        
    
        var charts = [temperature_chart, heart_rate_chart, eda_chart, ppg_chart, adxl_chart]; // add all charts (with axes) to be synced
     
        syncCharts(charts, true, true, true);
    
        console.log("synced ", location_prefix)
        for( var i = 0; i < charts.length; i++){
            charts[i].render();
          }
          
          if(location_prefix == 'dash'){
            $('#dd_progress_container').hide();
            $('#pat_desc_container').show();
           
          }else if(location_prefix == 'crisis_report'){
            $('#ce_no_sensor_data').hide()
            $('#ce_sensor_data_container').show()
          }
    }
    
}

function syncCharts(charts, syncToolTip, syncCrosshair, syncAxisXRange) {

    if(!this.onToolTipUpdated){
      this.onToolTipUpdated = function(e) {
        for (var j = 0; j < charts.length; j++) {
          if (charts[j] != e.chart)
            charts[j].toolTip.showAtX(e.entries[0].xValue);
        }
      }
    }

    if(!this.onToolTipHidden){
      this.onToolTipHidden = function(e) {
        for( var j = 0; j < charts.length; j++){
          if(charts[j] != e.chart)
            charts[j].toolTip.hide();
        }
      }
    }

    if(!this.onCrosshairUpdated){
      this.onCrosshairUpdated = function(e) {
        for(var j = 0; j < charts.length; j++){
          if(charts[j] != e.chart)
            charts[j].axisX[0].crosshair.showAt(e.value);
        }
      }
    }

    if(!this.onCrosshairHidden){
      this.onCrosshairHidden =  function(e) {
        for( var j = 0; j < charts.length; j++){
          if(charts[j] != e.chart)
            charts[j].axisX[0].crosshair.hide();
        }
      }
    }

    if(!this.onRangeChanged){
      this.onRangeChanged = function(e) {
        for (var j = 0; j < charts.length; j++) {
          if (e.trigger === "reset") {
            charts[j].options.axisX.viewportMinimum = charts[j].options.axisX.viewportMaximum = null;
            // charts[j].options.axisY.viewportMinimum = charts[j].options.axisY.viewportMaximum = null;
            charts[j].render();
          } else if (charts[j] !== e.chart) {
            charts[j].options.axisX.viewportMinimum = e.axisX[0].viewportMinimum;
            charts[j].options.axisX.viewportMaximum = e.axisX[0].viewportMaximum;
            charts[j].render();
          }
        }
      }
    }

    for(var i = 0; i < charts.length; i++) { 

      //Sync ToolTip
      if(syncToolTip) {
        if(!charts[i].options.toolTip)
          charts[i].options.toolTip = {};

        charts[i].options.toolTip.updated = this.onToolTipUpdated;
        charts[i].options.toolTip.hidden = this.onToolTipHidden;
      }

      //Sync Crosshair
      if(syncCrosshair) {
        if(!charts[i].options.axisX)
          charts[i].options.axisX = { crosshair: { enabled: true }};
		
        charts[i].options.axisX.crosshair.updated = this.onCrosshairUpdated; 
        charts[i].options.axisX.crosshair.hidden = this.onCrosshairHidden; 
      }

      //Sync Zoom / Pan
      if(syncAxisXRange) {
        charts[i].options.zoomEnabled = true;
        charts[i].options.rangeChanged = this.onRangeChanged;
      }
    }
  }  