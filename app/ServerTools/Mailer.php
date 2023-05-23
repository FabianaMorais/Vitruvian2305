<?php

namespace App\ServerTools;
use App\Mail\MailToPro;
use App\Mail\MailToPatient;
use App\Mail\MailToAdmin;
use App\Mail\MailFeedback;
use Mail;
use Log;
use App\Models\Users\User;

/**
 * Handles all email events except for the default Laravel ones
 * 
 * NOTE: Failing to send an email does not cause the system to crash. The email is simply logged
 */
class Mailer
{
    // TODO: Emails should be in the receiver's language
    // TODO: Implement a safety switch system that always sends emails toa a default email account if in debug mode


    /**
     * Sends an email to a patient
     */
    public static function sendEmailToPatient(String $email, String $subject, String $text) {

        try {
            Mail::to( $email )->send(new MailToPatient($subject, $text));

        } catch (\Exception $e) {
            Log::debug("[ERROR] sending email to " . $email);
            Log::debug("Subject: " . $subject);
            Log::debug("Text:");
            Log::debug($text);
            Log::debug("-------------------- Stack Trace --------------------");
            Log::debug($e);
        }
    }


    /**
     * Sends an email to a professional
     */
    public static function sendEmailToPro(String $email, String $subject, String $text) {

        try {
            Mail::to( $email )->send(new MailToPro($subject, $text));

        } catch (\Exception $e) {
            Log::debug("[ERROR] sending email to " . $email);
            Log::debug("Subject: " . $subject);
            Log::debug("Text:");
            Log::debug($text);
            Log::debug("-------------------- Stack Trace --------------------");
            Log::debug($e);
        }
    }


    /**
     * Sends an email to an admin
     */
    public static function sendEmailToAdmin(String $email, String $subject, String $text) {

        try {
            Mail::to( $email )->send(new MailToAdmin($subject, $text));

        } catch (\Exception $e) {
            Log::debug("[ERROR] sending email to " . $email);
            Log::debug("Subject: " . $subject);
            Log::debug("Text:");
            Log::debug($text);
            Log::debug("-------------------- Stack Trace --------------------");
            Log::debug($e);
        }
    }

    /**
     * Sends an email to the feedback email list (mainly the development team)
     * with feedback from a user
     * @param user: User or NewUser model
     */
    public static function sendFeedbackEmail($user, String $text) {

        Log::debug($text);

        $subject = "Feedback from user " . $user->name;

        // Adding intro to email's body
        $mailText = "Feedback from user [" . $user->name . "] with email [" . $user->email . "] and the following message:<br><br><br>" . $text;

        $feedbackEmails = config('vitruvian.emails_feedback'); // Retrieving list of emails to send feedback to
        for ($i = 0; $i < count($feedbackEmails); $i ++) {

            try {
                Mail::to( $feedbackEmails[$i] )->send(new MailFeedback($subject, $mailText));
    
            } catch (\Exception $e) {
                Log::debug("[ERROR] sending email to " . $user->email);
                Log::debug("Subject: " . $subject);
                Log::debug("Text:");
                Log::debug($mailText);
                Log::debug("-------------------- Stack Trace --------------------");
                Log::debug($e);
            }
        }
    }

}