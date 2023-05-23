<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use App\ServerTools\Mailer;

class ProfessionalController extends Controller
{

    /**
     * Sends a feedback message to the development team
     */
    public function postFeedbackForm(Request $req) {
        $req->validate([
            'in_feedback_msg' => 'min:20|max:50000',
        ], [
            // No custom validation messages
        ], [
            // Custom attribute names for default returned messages
            'in_feedback_msg' => lcfirst(trans('validation.FIELD')),
        ]);

        Mailer::sendFeedbackEmail( Auth::user(), $req->in_feedback_msg );
    }


    /**
     * Retrieves a professional's record to be displayed in the UI
     * @return stdClass with key (user uuid) and a view with the professional's record (record_ui)
     * name('pros.ui.record')
     */
    public function getProUIRecord(Request $req) // getProRecordUI?
    {


        // TODO: only owner, team or team partner may view this


        $req->validate([
            'pro_key' => 'uuid'
        ]);

        $proUser = User::where( 'id', $req->input('pro_key') )->get()->first();

        if ( isset($proUser) && $proUser->isProfessional() ) {

            $pro_entry = $proUser->getData();

            $resp = new \stdClass();
            $resp->key = $req->input('pro_key');
            $resp->record_ui = view('professionals.record.pro_record', compact('pro_entry'))->render();

        } else {
            abort(404);
        }

        return response()->json($resp, 200);
    }
}