<?php

namespace App\Http\Controllers\PublicAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PublicApiKey;
use App\Models\Users\User;

use Log;

/**
 * This controller is responsible for displaying the API
 * section pages for professionals, as well as generate
 * valid API keys
 */
class CredentialsController extends Controller
{


    // TODO: REMOVE TEMP
    public function testReq(Request $req) {


        Log::debug("Starting");

        $url = "192.168.1.89/api/v1/data/profile";


// $curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL => $url,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_HTTPHEADER => array(
//         "accept: application/json",
//         "content-type: application/json",
//         "username: testRes1",
//         "key: d!3e-K6ehzzwGSA#zrF6UzshNBDKntYKQ3xm2HJNgl"
//     ),
// ));

// $response = json_decode(curl_exec($curl));
// $err = json_decode(curl_error($curl)); // errors
// $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// curl_close($curl);

        $curl = curl_init();

        $fields = '{"patients":[
            "k7!f67un%sre",
            "xtwllecw8dg5",
            "lepzabvcnb1l"
        ]}';

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json",
                "username: testRes1",
                "key: d!3e-K6ehzzwGSA#zrF6UzshNBDKntYKQ3xm2HJNgl"
            ),
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $fields,
        ));

        $response = json_decode(curl_exec($curl));
        $err = json_decode(curl_error($curl)); // errors
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        Log::debug( $status );
        Log::debug(print_r( $response, true ));
        Log::debug(print_r( $err, true ));

        return "DONE";
    }





    /**
     * Displays the API section page
     */
    public function index(Request $req) {
        // Checking if user has API key. If so, we display it. If not, we display a button to generate one
        $currentKey = PublicApiKey::where('fk_user_id', Auth::user()->id)->get()->first();

        if (isset($currentKey)) {
            $key = $currentKey->key;
            return view('professionals.public_api_credentials', compact('key'));

        } else {
            return view('professionals.public_api_credentials');
        }
    }

    /**
     * Requests a new API key for the current user
     */
    public function requestApiKey(Request $req) {

        $currentKey = PublicApiKey::where('fk_user_id', Auth::user()->id)->get()->first();

        if (isset($currentKey)) { // If the current user already has a key
            abort(409);
        }

        if (!Auth::user()->isType(User::RESEARCHER)) { // Only researchers may access the public API
            abort(401);
        }

        // If not, generate one, save it and return it
        $key = new PublicApiKey();
        $key->fk_user_id = Auth::user()->id;
        $key->key = $this->generatePublicApiKey();
        $key->save();

        return response()->json(['key' => $key->key], 200);
    }

    /**
     * Algorithm to generate a public API key
     */
    private function generatePublicApiKey($length = 42) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz!#-ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Displays the docs page for the public API
     */
    public function showDocs(Request $req) {
        return view('api_docs.main');
    }
}
