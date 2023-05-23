<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Private API
 */
Route::prefix('shield')->group(function() {

    Route::POST('first-login','PrivateAPI\ApiAuthController@firstLogin');
    Route::POST('login','PrivateAPI\ApiAuthController@login');
    Route::POST('recover-password','PrivateAPI\ApiAuthController@recoverPassword');
    Route::POST('resend-code','PrivateAPI\ApiAuthController@resendCode');

    Route::middleware('auth:api')->group(function() { // Routes for authenticated users
        Route::GET('validate-token','PrivateAPI\ApiAuthController@validateToken');
        Route::POST('logout','PrivateAPI\ApiAuthController@logout');
        Route::POST('reset-password','PrivateAPI\ApiAuthController@changePassword');

        Route::POST('feedback/send','PrivateAPI\UserInputController@sendAppFeedback'); // Sends feedback to the devs from a smartphone app user
        //send data to mongodb database
        Route::POST('sensor-data/upload','PrivateAPI\DataSubmissionController@sensorDataSubmission');
        
        
        //add medication for a patient
        // Route::POST('medication/add','ApiController@addMedication');
        //remove a patient medication  taking

        Route::POST('medication/remove-taking','PrivateAPI\MedicationController@removeMedTaking');
        Route::POST('medication/add-taking','PrivateAPI\MedicationController@addMedTaking'); // set a patient medication as taken given a timestamp
        Route::POST('patient-medication/add','PrivateAPI\MedicationController@addPatientMedication'); // prescribe a patient a new medication
        Route::POST('patient-medication/remove','PrivateAPI\MedicationController@removePatientMedication'); // remove a self prescribed medication
        Route::POST('patient-medication/edit','PrivateAPI\MedicationController@editPatientMedication');

        Route::GET('patient-medication/full-list','PrivateAPI\MedicationController@getPatientFullMeds');

        /* NOTE: These functions aren't used by the private API anymore. Remove them from controller? Maybe some are useful in the future?
        Route::GET('patient-medication/schedule','PrivateAPI\MedicationController@getPatientFullFutureMedicationSchedule');
        Route::POST('medication/by-day','PrivateAPI\MedicationController@getPatientMedicationByDay'); // route to get patient medication for a certain day
        Route::GET('medication/list','PrivateAPI\MedicationController@getMedicationList'); //get full medication list for a patient*/

        Route::POST('crisis/add-new','PrivateAPI\UserInputController@addUserCrisisEvent');//add a crisis event to a patient
    });

});

/**
 * Public API
 */
Route::prefix('v1')->group(function() {

    Route::GET('/patients', 'PublicAPI\ProfessionalDataController@getOwnedPatients');
    Route::GET('/patients/all', 'PublicAPI\ProfessionalDataController@getPatients');
    Route::POST('/patients/teams', 'PublicAPI\ProfessionalDataController@getTeamPatients');

    Route::GET('/teams', 'PublicAPI\ProfessionalDataController@getTeams');
    Route::GET('/teams/organization', 'PublicAPI\ProfessionalDataController@getOrgTeams');

    Route::POST('/professionals/teams', 'PublicAPI\ProfessionalDataController@getTeamProfessionals');

    Route::POST('/data/profile', 'PublicAPI\PatientDataController@getPatientProfiles');
    Route::POST('/data/sensor-bundle', 'PublicAPI\SensorDataController@getSensorListData');


    // user crisis events
    Route::POST('/crisis-event/add', 'PublicAPI\PatientDataController@addPatientCrisisEvent');
    Route::POST('/crisis-event/view', 'PublicAPI\PatientDataController@getCrisisEventList');

    // medication
    Route::POST('/medication/add', 'PublicAPI\PatientDataController@addMedication');
    Route::POST('/medication/view/day', 'PublicAPI\PatientDataController@getMedicationByDay');
    Route::POST('/medication/end-treatment', 'PublicAPI\PatientDataController@setTreatmentEnd');
    
    Route::POST('/medication-intake/add', 'PublicAPI\PatientDataController@setMedTaking');
    Route::POST('/medication-intake/view/day', 'PublicAPI\PatientDataController@getMedTakingsForDay');
    Route::POST('/medication-intake/remove', 'PublicAPI\PatientDataController@removeMedTaking');

});