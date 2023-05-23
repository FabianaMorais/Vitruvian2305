<?php

use Illuminate\Database\Seeder;

use App\ServerTools\Mailer;
use App\Models\Users\User;



class TestSeeder extends Seeder
{

    public function run()
    {

      $text = "Example email text to send emails.<br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<br><br> Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

      $u = User::first();

      Mailer::sendFeedbackEmail( $u, $text );

    }

}
