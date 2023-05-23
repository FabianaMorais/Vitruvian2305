<?php

// Route::GET('/tests', function () { return view('widget_tests.tests'); });


/* REGISTERED: Routes accessible to all registered user types
------------------------------------------------------------ */
// Routes accessible to all users (both new and accepted)
Route::middleware('auth', 'verified')->group( function() {
    Route::GET('/home', 'HomeController@index')->name('home');
    Route::GET('/profile', 'ProfileController@index' )->name('profile');
    Route::POST('/profile/update', 'ProfileController@updateProfile')->name('profile.update');
    Route::POST('/profile/change-password', 'ProfileController@changePassword' )->name('profile.change_pw');
    Route::POST('/profile/delete', 'ProfileController@deleteAccount')->name('profile.delete');


    Route::GET('/feedback', function () { return view('professionals.feedback_form'); } )->name('beta.feedback');
    Route::POST('/feedback/send', 'ProfessionalController@postFeedbackForm' )->name('beta.feedback.send');

});


/* TRUSTWORTHY USERS: Routes accessible to all trustworthy webapp user types
------------------------------------------------------------ */
Route::middleware('auth:web', 'verified', 'access:org,pro,admin')->group( function() {
    // View professional record
    Route::GET('/manage-pros/view', 'ProfessionalController@getProUIRecord')->name('pros.ui.record');

    // Team management
    Route::GET('/teams', 'TeamsController@index')->name('teams.index');
    Route::GET('/teams/add', 'TeamsController@addTeamForm')->name('teams.new');
    Route::GET('/teams/view/{teamkey}', 'TeamsController@viewTeam')->name('teams.view');
    Route::POST('/teams/add/save', 'TeamsController@saveNewTeam')->name('teams.save');
    Route::POST('/teams/update/settings', 'TeamsController@updateSettings')->name('teams.update.settings');
    Route::POST('/teams/delete/{teamKey}', 'TeamsController@deleteTeam')->name('teams.update.delete');
    Route::GET('/teams/pros-vs-team', 'TeamsController@getProsVsTeamUIList')->name('teams.pros_vs_team');
    Route::POST('/teams/update/pros', 'TeamsController@updateTeamProfessionals')->name('teams.update.pros');
    Route::GET('/teams/patients-vs-team', 'TeamsController@getPatientsVsTeamUIList')->name('teams.patients_vs_team');
    Route::POST('/teams/update/patients', 'TeamsController@updateTeamPatients')->name('teams.update.patients');

});


/* ORGANIZATIONS
------------------------------------------------------------ */
Route::middleware('auth:web', 'verified', 'access:org')->group( function() {
    Route::GET('/manage-pros', 'OrganizationController@indexPros')->name('org.manage.pros');
    Route::GET('/manage-pros/add', 'OrganizationController@addProForm')->name('org.manage.pros.new');
    Route::GET('/manage-pros/edit/{proKey}', 'OrganizationController@editProForm')->name('org.manage.pros.edit');
    Route::POST('/manage-pros/save-edit', 'OrganizationController@saveEditPro')->name('org.manage.pros.save_edit');
    Route::POST('/manage-pros/save-new', 'OrganizationController@saveNewPro')->name('org.manage.pros.save_new');
    Route::POST('/manage-pros/delete/{proKey}', 'OrganizationController@removePro')->name('org.manage.pros.delete');
});

/* PROFESSIONALS: Routes accessible to all Professional types
------------------------------------------------------------ */
Route::middleware('auth:web', 'verified', 'access:pro')->group( function() {
    Route::GET('/new_patient', 'PatientController@addPatientForm')->name('patients.new.form');
    Route::POST('/new_patient', 'PatientController@saveNewPatient')->name('patients.new.submit');
    Route::POST('/patient/update-health', 'PatientController@updatePatientProfile')->name('patients.update.health_profile');

    Route::GET('/medication/patient/date','PatientController@getMedicationForDay')->name('get patient medication for day');
    Route::post('/new_med_schedule', 'PatientController@new_medication_schedule')->name('new med schedule form submit'); // adding medication schedule
    Route::get('/crisis-event-report', 'UserCrisisController@getCrisisReportIndex')->name('crisis event report home'); // add new crisis event
    Route::post('/new_crisis_event', 'PatientController@new_crisis_event')->name('new crisis event form submit'); // add new crisis event
    Route::POST('/delete-medication','MedicationController@deleteMedication');
    Route::POST('/get-medication-data','MedicationController@getTreatmentEditionData');
    Route::POST('/edit-med-schedule','MedicationController@editTreatment');
    
    Route::get('/patients', 'PatientController@index')->name('list patients'); // Listing patients
    Route::get('/view-patient', 'PatientController@get_patient_description_by_id'); // Patient info page
    Route::get('/view-patient/chart-filter', 'PatientController@getPatientDataForCharts');
    
    Route::get('/patient_password/recover', 'PatientController@recoverPatientPassword')->name('recover patient password form'); // Patient password recovery
    Route::post('/patient_password/recover', 'PatientController@sendPatientPasswordRecoveryEmail')->name('recover patient password form submit');

    //Download data for research
    Route::get('/download', 'PatientController@downloadOptionsView')->name('download csv data options view');
    
    Route::post('/data/export', 'PatientController@exportPatientData')->name('download data for all patients');
    Route::post('/data/fetch-bucket-list', 'PatientController@fetchPatientBucketList')->name('download bucket list for one patient');
    
    // Route::post('/download/csv', 'PatientController@buildAndDownloadData')->name('download csv data for all patients');
});


/* RESEARCHERS
------------------------------------------------------------ */
Route::middleware('auth:web', 'verified', 'access:res')->group( function() {
    Route::GET('/api-credentials', 'PublicAPI\CredentialsController@index')->name('public_api.credentials');
    Route::POST('/api-credentials/generate-key', 'PublicAPI\CredentialsController@requestApiKey')->name('public_api.generate_key');
});

/* MEDICAL PROFESSIONALS
------------------------------------------------------------ */
Route::middleware('auth:web', 'verified', 'access:doc')->group( function() {

});

/* CAREGIVERS
------------------------------------------------------------ */
Route::middleware('auth:web', 'verified', 'access:care')->group( function() {

});

/* ADMINS
------------------------------------------------------------ */
Route::middleware('auth:web', 'verified', 'access:admin')->group( function() {
    Route::get('/admin/registrations', 'UserManagementController@showManageRegistrationsView')->name('admin.registrations');
    Route::get('/admin/registrations/view', 'UserManagementController@viewRegistrationEntry');
    Route::post('/admin/registrations/accept', 'UserManagementController@acceptRegistration');
    Route::post('/admin/registrations/refuse', 'UserManagementController@refuseRegistration');
});

/* PUBLIC PAGES
------------------------------------------------------------ */
// Routes accessible to UNREGISTERED users only

Auth::routes(['verify' => true]); // Routes for registry, login and password recovery

Route::middleware('guest')->group( function() {
    Route::get('/', function () { return view('public_pages.welcome_page'); })->name('welcome');

    Route::get('/policies/users', function () { return view('public_pages.policies.patients'); })->name('patient policies');
    Route::get('/policies/professionals', function () { return view('public_pages.policies.professionals'); })->name('professional policies');
    Route::get('/policies/organizations', function () { return view('public_pages.policies.organizations'); })->name('organization policies');
    Route::get('/certifications', function () { return view('public_pages.certifications'); })->name('certifications');
    Route::get('/our-path', function () { return view('public_pages.our_path'); })->name('our path');
    Route::get('/partners', function () { return view('public_pages.our_partners'); })->name('partners');
    Route::get('/team', function () { return view('public_pages.our_team'); })->name('team');

    // Selling pages
    Route::get('/problem', function () { return view('public_pages.the_problem'); })->name('problem');
    Route::get('/concept', function () { return view('public_pages.the_concept'); })->name('concept');
    Route::get('/watch', function () { return view('public_pages.the_smartwatch'); })->name('watch');
    Route::get('/mobile-app', function () { return view('public_pages.the_mobile_app'); })->name('mobile app');
    Route::get('/data', function () { return view('public_pages.data_and_research'); })->name('data');
    Route::get('/microsoft-azure-cloud', function () { return view('public_pages.microsoft-azure-cloud'); })->name('microsoft azure cloud');
    Route::get('/research', function () { return view('public_pages.research_participation'); })->name('research');
    Route::get('/research-api', function () { return view('public_pages.the_research_api'); })->name('research api');
    Route::get('/become-a-partner', function () { return view('public_pages.become_partner'); })->name('become partner');
    Route::get('/donations', function () { return view('public_pages.donations'); })->name('donations');
    Route::get('/contact-us', function () { return view('public_pages.contact_us'); })->name('contact us');

    Route::GET('/for-individuals', function () { return view('public_pages.for_individuals'); })->name('pitch.patients');
    Route::GET('/for-professionals-and-organizations', function () { return view('public_pages.for_professionals'); })->name('pitch.pros');
    Route::GET('/for-researchers', function () { return view('public_pages.for_researchers'); })->name('pitch.researchers');

    // Contact form
    Route::post('/contact_us', 'AnonymousController@anonymousContactFormSubmit')->name('contact form submit');
});

/* UNRESTRICTED PAGES
------------------------------------------------------------ */
// Routes accessible to ALL users
Route::GET('/api/docs', 'PublicAPI\CredentialsController@showDocs')->name('public_api.docs');