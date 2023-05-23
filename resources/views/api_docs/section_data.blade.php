<div id="i-data" class="mt-5">
    <h3 class="h3">Patient Data</h3>

    <label>The following requests allow you to retrieve health patient data in bulk.</label>

</div>

<div id="i-get-profile" class="mt-4">
    <h5 class="h5">Health Profile</h5>
    <label>Requests the health profile for the passed list of patients.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /data/profile
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                    ['attributes' => [
                        'patients' => 'REQUIRED - An array of patient codes'
                        ]
                    ])
                @endcomponent
            @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
                ['attributes' => [
                    'code' => 'the current patient\'s code',
                    'gender' => 'male, female or "unspecified"',
                    'date_of_birth' => 'in yyyy/mm/dd format or "unspecified"',
                    'country' => 'in Alpha-2 (ISO 3166) nomenclature or "unspecified"',
                    'weight_kg' => 'patient\'s weight measured in Kg or "unspecified"',
                    'blood_type' => 'one of A+, A-, B+, B-, AB+, AB-, O+, O- or "unspecified"',
                    'diagnosed_diseases' => 'textual description or "none"',
                    'other_conditions' => 'textual description or "none"'
                    ]
                ])
                @slot('objects_in_array') Patient Profile Data @endslot
            @endcomponent
        @endslot
    @endcomponent

</div>




<div id="i-get-sensorbundle" class="mt-4">
    <h5 class="h5">Sensor Data Bundle</h5>
    <label>Requests the data from a passed list of sensors for the passed list of patients within a specified datetime interval.<br/>
    If datetime interval is not specified, fetches all the collected data for the passed list of patients.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /data/sensor-bundle
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                ['attributes' => [
                    'patients' => 'REQUIRED - An array of patient codes',
                    'sensor_list' => 'REQUIRED - An array of sensors to obtain data for. Possible values: "adpd", "adxl", "ecg", "eda", "pedometer", "ppg", "syncppg", "temperature", "bcm", "sqi"',
                    'start_date' => 'OPTIONAL - Defines a minimum timestamp to request data for in yyyy-mm-dd hh:mm:ss format',
                    'end_date' => 'OPTIONAL - Defines a maximum timestamp to request data for in yyyy-mm-dd hh:mm:ss format'
                    ]
                ])
            @endcomponent
        @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
            ['attributes' => [
                'patient' => 'sequential number given to each patient that has their data downloaded',
                'data' => 'array of all sensor data collections for the patient where each collection is an array of sensor data'
                ]
            ])
                @slot('objects_in_array') Data Collection @endslot
            @endcomponent
        @endslot
    @endcomponent

</div>

<div id="i-add-medication" class="mt-4">
    <h5 class="h5">Prescribe Medication</h5>
    <label>Adds a medication to a patient's medication schedule.<br/>
    If treatment end date is not defined the treatment will continue indefinitely.<br/>
    If periodicity is not defined, the treatment will be scheduled for every until the treatment end date.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /medication/add
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                ['attributes' => [
                    'patient' => 'REQUIRED - string value with the patient\'s code',
                    'medication_name' => 'REQUIRED - string value with the medication name',
                    'medication_dosage' => 'REQUIRED - numeric value with the medication\'s dosage per pill in mg',
                    'medication_type' => 'REQUIRED - string value defining the type of medication. Possible values: "capsule", "pill", "syrup","supository","other"',
                    'periodicity' => 'OPTIONAL - numeric value of periodicity in days of the intakes',
                    'start_timestamp' => 'REQUIRED - defines the starting timestamp of the treatment in yyyy-mm-dd hh:mm:ss format',
                    'treatment_duration' => 'OPTIONAL  - numeric value of the treatment duration in days',
                    'scheduled_intakes' => 'REQUIRED - array with the medication schedule for a day defined as:',
                     '[' => '',
                    'intake_time' => 'REQUIRED - string with time value in the format "hh:mm"',
                    'pills_per_intake' => 'REQUIRED - numeric value of the number of pills to take at the defined time', 
                    ']' => ''
                    
                    ]
                ])
            @endcomponent
        @endslot
    @endcomponent

</div>

<div id="i-get-medication-for-day" class="mt-4">
    <h5 class="h5">Get Medication Schedule By Day</h5>
    <label>Requests the medication schedule for the patient and the day .<br/>
    If datetime interval is not specified, fetches all the collected data for the passed list of patients.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /medication/view/day
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                ['attributes' => [
                    'patients' => 'REQUIRED - An array of patient codes',
                    'date' => 'REQUIRED - Date value in yyyy-mm-dd format to obtain the medication schedule for',
                    ]
                ])
            @endcomponent
        @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
            ['attributes' => [
                'prescription_id' => 'string value of the prescription\'s id',
                'skin_temperature' => 'numeric value of the skin temperature',
                'patient' => 'string value defining the patient which the prescription refers to',
                'start_date' => 'treatment start date in yyyy-mm-dd hh:mm:ss format',
                'medication' => 'description of the medication scheduled for intake',
                'intake_time' => 'time defined for an intake in hh:mm format',
                'intake_amount' => 'numeric value of the number of pills defined for an intake'
                ]
            ])
                @slot('objects_in_array') Medication prescription @endslot
            @endcomponent
        @endslot
    @endcomponent

</div>


<div id="i-end-treatment" class="mt-4">
    <h5 class="h5">End Treatment</h5>
    <label>Sets a treatment as completed in the moment the request is done.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /medication/end-treatment
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                ['attributes' => [
                    'prescription_id' => 'REQUIRED - String value of the prescription id'
                    ]
                ])
            @endcomponent
        @endslot
    @endcomponent

</div>


<div id="i-add-medication-intake" class="mt-4">
    <h5 class="h5">Add Medication Intake</h5>
    <label>Adds a medication intake to a patient's medication schedule.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /medication-intake/add
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                ['attributes' => [
                    'prescription_id' => 'REQUIRED - String value of the prescription id',
                    'date' => 'REQUIRED - Date value in yyyy-mm-dd format',
                    'daily_intake_number' => 'REQUIRED - Numeric value for the intake of the day'
                ]
            ])
            @endcomponent
        @endslot
    @endcomponent

</div>

<div id="i-remove-medication-intake" class="mt-4">
    <h5 class="h5">Remove Medication Intake</h5>
    <label>Removes a medication intake from a patient's medication schedule.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /medication-intake/remove
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                ['attributes' => [
                    'prescription_id' => 'REQUIRED - String value of the prescription id',
                    'date' => 'REQUIRED - Date value in yyyy-mm-dd format',
                    'daily_intake_number' => 'REQUIRED - Numeric value for the intake of the day'
                    ]
                ])
            @endcomponent
        @endslot
    @endcomponent

</div>


<div id="i-add-crisis-event" class="mt-4">
    <h5 class="h5">Add Crisis Event</h5>
    <label>Adds a crisis event to a patient's history.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /crisis-event/add
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                ['attributes' => [
                    'patient' => 'REQUIRED - string value with the patient\'s code',
                    'timestamp' => 'REQUIRED - timestamp of the crisis event start in yyyy-mm-dd hh:mm:ss format',
                    'duration' => 'REQUIRED  - numeric value of the crisis event\'s duration in seconds',
                    'crisis_event' => 'REQUIRED - string value with the crisis event name. Possible values: "ep_absence_seizure", "ep_seizure", "loss_balance", "loss_consciousness", "fall", "other"',
                    'notes' => 'OPTIONAL - string value with a brief description of the crisis event'
                    ]
                ])
            @endcomponent
        @endslot
    @endcomponent

</div>

<div id="i-get-crisis-event-list" class="mt-4">
    <h5 class="h5">Get Crisis Event List</h5>
    <label>Gets a list of crisis events associated to a list of patients' history within a specified datetime interval.<br/>
    If datetime interval is not specified, fetches all the collected data for the passed list of patients.</label>

    @component('api_docs.box_request')
        @slot('method') POST @endslot
        @slot('route')
            /crisis-event/view
        @endslot
        @slot('expected')
            @component('api_docs.expected_values_component', 
                ['attributes' => [
                    'patients' => 'REQUIRED - An array of patient codes',
                    'start_date' => 'OPTIONAL - Defines a minimum timestamp to request data for in yyyy-mm-dd hh:mm:ss format',
                    'end_date' => 'OPTIONAL - Defines a maximum timestamp to request data for in yyyy-mm-dd hh:mm:ss format'
                    ]
                ])
            @endcomponent
        @endslot
        @slot('returned')
            @component('api_docs.returned_values_component', 
            ['attributes' => [
                'crisis_date' => 'date value of the crisis event in yyyy-mm-dd format',
                'crisis_time' => 'time value of the crisis event in hh:mm format',
                'duration_in_seconds' => 'numeric value of the duration in seconds of the crisis event',
                'patient' => 'the current patient\'s code',
                'submitted_by_doctor' => 'boolean value which defines if a crisis event was added by a professional or a patient',
                'crisis_event' => 'string value of the crisis event\'s name'
                ]
            ])
                @slot('objects_in_array') Crisis Event @endslot
            @endcomponent
        @endslot
    @endcomponent
</div>