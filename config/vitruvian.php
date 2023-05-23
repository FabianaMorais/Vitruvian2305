<?php

return [

    /*
     * Account administrator's email
     */
    'email_admin' => env('MAIL_ADMIN', 'support@vitruvianshield.com'),

    /*
     * Email list for sending feedback emails.
     * Emails must be in a continuous string separated by , and no spaces
     */
    'emails_feedback' => explode(',', env('MAILS_FEEDBACK', 'support@vitruvianshield.com','fabiana.rodrigues@vitruvianshield.com') ),
];