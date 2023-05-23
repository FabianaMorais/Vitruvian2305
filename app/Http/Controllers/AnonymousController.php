<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServerTools\Mailer;
use App\Rules\ReCAPTCHAv3;

class AnonymousController extends Controller
{
    public function anonymousContactFormSubmit(Request $request){
        $rules = [
            'sender_name' => 'required|string|min:3|max:50',
            'subject' => 'required|string|min:3|max:50',
            'message' => 'required|string|min:3|max:1200',
            'sender_email' => 'required|email',
            //min 9 for Portugal, max 14 beacuse  for some other 
            //countries they have 10 + 4 indicative i.e.+351
            'sender_phone_number' => 'string|min:9|max:14',

            //recaptchav3
            'grecaptcha' => ['required', new ReCAPTCHAv3],
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'), 
            'email' => trans('pg_professionals.INVALID_EMAIL'),
            'sender_name.min' => trans('pg_professionals.MIN_CHARS_FIELD_3'),
            'sender_name.max' => trans('pg_professionals.MIN_CHARS_FIELD_50'),
            'subject.min' => trans('pg_professionals.MIN_CHARS_FIELD_3'),
            'subject.max' => trans('pg_professionals.MIN_CHARS_FIELD_50'),
            'message.min' => trans('pg_professionals.MIN_CHARS_FIELD_3'),
            'message.max' => trans('pg_professionals.MIN_CHARS_FIELD_1200'),
            'sender_phone_number.min' => trans('pg_professionals.MIN_CHARS_FIELD_9'),
            'sender_phone_number.max' => trans('pg_professionals.MIN_CHARS_FIELD_14'),
        ];

        $request->validate($rules,$messages);

        $subject = $request->input('subject');
        $text = $request->input('message') . "<br><br>Sent by:<br>".$request->input('sender_email')." -> " . $request->input('sender_phone_number');
        Mailer::sendEmailToAdmin(config('vitruvian.email_admin'), $subject, $text);

        $form_submitted = true;
        return view('public_pages.become_partner',compact(['form_submitted']));
    }
}
