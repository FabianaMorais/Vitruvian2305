<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $text;

    public function __construct(String $s, String $t)
    {
        $this->subject = $s;
        $this->text = $t;
    }

    public function build() {
        return $this->view('mails.mail_to_admin')
                    ->subject( $this->subject );
    }
}
