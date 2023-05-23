<?php

namespace App\Http\Controllers\PrivateAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ServerTools\MongoManager;


use Carbon\Carbon;
use Log;

class DataSubmissionController extends Controller
{
    //
    public function sensorDataSubmission(Request $request) {
        if (!$request->user()->isPatient()) {
            abort(401);
        }

        $request->validate([
            'use_case' => 'required|string|min:5|max:80',
            'unix_datetime' => 'required|numeric',
            'data' => 'required|array',
            'data.*.unix_timestamp' => 'required|numeric',
            'data.*.adxl_x' => 'numeric',
            'data.*.adxl_y' => 'numeric',
            'data.*.adxl_z' => 'numeric'
        ]);

        $mongo_manager = new MongoManager();
        
        $http_code = $mongo_manager->insertData($request->unix_datetime,$request->use_case,$request->data,$request->user()->getRoleData()->inscription_code);
        return response()->json("success",$http_code);
        
        
        
    }
}
