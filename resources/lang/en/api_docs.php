<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public API Documentation
    |--------------------------------------------------------------------------
    */

    // Credentials page
    'PG_TITLE' => 'Vitruvian Shield API',
    'PANEL_TITLE' => 'Overview',
    'PANEL_DESC_A' => 'With the Vitruvian Shield API you\'re able to collect you patients\' biometric data in bulk.',
    'PANEL_DESC_B' => 'You can use this data in your research or to create your own research applications. Keep in mind you\'ll only be able to access data with your patients\' explicit consent. All data is anonymized.',
    'PANEL_DESC_GENERATE' => 'Start by generating your own personal API key.',
    'PANEL_DESC_DOCS' => 'You can view the documentation <a href="' . route("public_api.docs") . '"><u>here</u></a>',
    'BTN_GENERATE_KEY' => 'Generate Key',

    'KEY_TITLE' => 'API Key',
    'KEY_DESC' => 'Your Vitruvian Shield key must be sent in every request in order to use the API.<br>Please note that this key is for personal use only. <u>Do not share your API key with anyone.</u>',


    // Documentation
    'REQUEST_EXPECTED' => 'Expected body:',
    'REQUEST_RESPONSE' => 'Response:',
];
