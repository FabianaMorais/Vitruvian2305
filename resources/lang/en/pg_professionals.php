<?php

return [


    //validation messages
    'REQUIRED_FIELD' => 'This field cannot be blank',
    'INVALID_EMAIL' => 'Please use a valid email address',
    'UNIQUE_EMAIL' => 'This email is already in use, please choose another',
    'MIN_CHARS_FIELD_3' => 'This field requires a minimum of 3 characters',
    'MIN_CHARS_FIELD_6' => 'This field requires a minimum of 6 characters',
    'MIN_CHARS_FIELD_9' => 'This field requires a minimum of 9 characters',
    'MIN_CHARS_FIELD_12' => 'This field requires a minimum of 12 characters',
    'MIN_CHARS_FIELD_14' => 'This field requires a minimum of 14 characters',
    'MIN_CHARS_FIELD_50' => 'This field requires a minimum of 50 characters',
    'MIN_CHARS_FIELD_1200' => 'This field requires a minimum of 1200 characters',

    'MAX_CHARS_FIELD_12' => 'This field requires a maximum of 12 characters',
    'MAX_CHARS_FIELD_16' => 'This field requires a maximum of 16 characters',

    'CONFIRMED_FIELD' => 'The password confirmation does not match given password',
    'NUMERIC_FIELD' => 'This field must be a number',
    'MAX_CHARS_FIELD_300' => 'This field requires a maximum of 16 characters',
    
    //form fields
    'PATIENT_EMAIL' => 'Patient email',

    // Feedback form
    'PG_FEEDBACK_FORM_TITLE' => 'Send Us Your Feedback',
    'FEEDBACK_FORM_TITLE' => 'Your Feedback is Always Welcome',
    'FEEDBACK_FORM_TEXT_A' => 'Feel free to tell us what you think about Vitruvian Shield.<br>Is there a particular feature you\'re looking for? Do you have any suggestion to improve your user experience?',
    'FEEDBACK_FORM_TEXT_B' => 'Send us your feedback.<br>We\'ll consider every message.',
    'YOUR_FEEDBACK_PH' => 'Your feedback message',
    'BTN_SEND_FEEDBACK' => 'Send Feedback',



    //patient listing
    'LIST_PATIENTS_TTL' => 'Patients',
    'LIST_PATIENTS_DESC' => 'Manage your patients and their personal information',
    'PATIENT_STILL_NOT_REGISTERED' => 'This patient still hasn\'t completed his registration.',
    'PATIENT_STILL_NOT_REGISTERED_2' => 'Give them some time! Go back to the dashboard meanwhile.',
    'CHOOSE_TO_VIEW_PATIENT' => 'Select a patient to view their information',
    'CHOOSE_ONE' => 'Select a patient',
    'EMAIL_LBL' => 'Email:',
    
    //medication
    'MEDICATION_BUTTON' => 'List',
    'ADD_MEDICATION_BUTTON' => 'Add new',
    'EDITING_MEDICATION_TTL' => 'Edit Medication',
    'MEDICATION_NAME' => 'Name',
    'MEDICATION_DOSAGE' => 'Dosage',
    'MEDICATION_TYPE' => 'Type',
    'MEDICATION_NUMBER_OF_PILLS' => 'Number of pills',
    'MEDICATION_SCHEDULE' => 'Medication schedule',
    'MEDICATION_START' => 'Start at',
    'MEDICATION_DURATION_IN_DAYS' => 'Treatment duration',
    'PERIODICITY_LBL' => 'Per X days',
    'NUMBER_OF_TAKINGS' => 'Number of takings',
    'AMOUNT_TO_TAKE_LBL' => 'Number of pills',
    'HOURS_TO_TAKE_LBL' => 'Hours',
    'MINS_TO_TAKE_LBL' => 'Minutes',
    'MEDICATION_INTAKE_TIME' => 'Time',
    'MEDICATION_INFO' => 'Description',
    'FULL_MED_LIST' => 'Complete medication list',
    'TODAY' => 'Today',
    'TOMORROW' => 'Tomorrow',
    'IN_2_DAYS' => 'In 2 days',
    'IN_3_DAYS' => 'In 3 days',
    'IN_4_DAYS' => 'In 4 days',
    'IN_5_DAYS' => 'In 5 days',
    'IN_6_DAYS' => 'In 6 days',
    'FOREVER' => 'Indefinite',
    'SET_ENDDATE' => 'Set end date',
    

    'MODAL_MED_TTL'=>'Add new medication schedule',
    'CLOSE' => 'Close',
    'SAVE' => 'Save',
    'CANCEL' => 'Cancel',

 
    
    //User crisis events
    'TOTAL_HEART_ATTACK_COUNT' => 'Total heart attacks ',
    'TOTAL_EPILEPTIC_SEIZURE_COUNT' => 'Total epileptic seizures ',
    'ADD_CRISIS_EVENT_BUTTON' => 'Add new',
    'VIEW_CRISIS_EVENT_REPORT_BUTTON' => 'Report',
    'MODAL_USER_CRISIS_TTL' => 'Add new patient crisis event',
    'DURATION_IN_SECONDS' => 'Duration in seconds',
    'CRISIS_NOTES' => 'Notes',
    'CRISIS_DATE' => 'Crisis event date',
    'CRISIS_TIME' => 'Crisis event time',
    'CRISIS_DAY'=> 'Day',
    'CRISIS_MONTH'=> 'Month',
    'CRISIS_YEAR'=> 'Year',
    'CRISIS_HOUR' => 'Hour',
    'CRISIS_MINUTE' => 'Minute',
    

    //password recovery
    'RECOVER_PASSWORD_TTL' => 'Recover password',
    'RECOVER_PASSWORD_DESC' => 'Send a link to reset a patient\'s password',

    //data download
    'MANAGE_DATA' => 'Export Data',
    'DATE_RANGE_SELECTION_TTL' => 'Date range selection:',
    'FILE_TYPE_SELECTION_TTL' => 'File type selection:',
    'CRISIS_SELECTION_TTL' => 'Crisis event selection:',
    'JSON' => 'JSON',
    'CSV' => 'CSV',
    'DOWNLOAD' => 'Download',
    'DOWNLOAD_DATA_TTL' => 'Export Patient Data',
    'DOWNLOAD_DATA_DESC' => 'Download your patients\' data in csv format',
    'ALL' => 'All',
    'CHOOSE' => 'Choose from list',
    'USERS' => 'User selection',
    'SENSOR_LIST' => 'Sensor selection',
    
    'SENSOR_1_NAME' => 'Motion ACC',
    'SENSOR_2_NAME' => 'Electrodermal Activity',
    'SENSOR_3_NAME' => 'Photopletismography',
    'SENSOR_4_NAME' => 'Temperature',
    'SENSOR_5_NAME' => 'Sync PPG',
    'USE_DATA_SUBMITTED_BY_USERS' => 'Use crisis events submitted by users',
    'DATA_SELECTION' => ' Data selection',
    'FETCHING_RECORD_LBL' => 'Fetching record ',
    'DONWLOAD_TYPES_DESC' => '*JSON files prioritize speed but disable sensor selection. CSV files may take a while to download but allow sensor selection.',
    //errors for data download form
    'NO_USERS_ERROR' => 'Please select at least one user',
    'NO_SENSORS_ERROR' => 'Please select at least one sensor',
    'NO_PATIENTS_FOR_DOWNLOAD_TTL' => 'No Patients!',
    'NO_PATIENTS_FOR_DOWNLOAD_DESC' => 'Add patients to monitor their health signals so you can later download their data.',
    'NO_PATIENTS_FOR_DOWNLOAD_BTN' => 'Add patient',

    'DATA_LOSS_DESC'=>'If you have lost data, please check your Internet Connection and try again.',
    'DOWNLOAD_REPORT' => 'Download Report',
    'RETRY' => 'Retry',
    'FINISH' => 'Finish',
    'DOWNLOADED_LBL' => 'Downloaded ',
    'OUT_OF_LBL' => ' out of ',
    'RECORDS_LBL' => ' records ',

    //team dashboard buttons
    'LIST_TEAMS_TTL' => 'View',
    'LIST_TEAMS_DESC' => 'Manage your teams and their members',
    'ADD_TEAM_TTL' => 'Add',
    'ADD_TEAM_DESC' => 'Create user teams or groups',

    'FETCHING_CHART_DATA' => 'Fetching data for charts',
    
];
