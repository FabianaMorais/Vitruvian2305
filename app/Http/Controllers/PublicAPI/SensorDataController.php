<?php

namespace App\Http\Controllers\PublicAPI;

use Illuminate\Http\Request;

use App\ServerTools\MongoManager;

use Carbon\Carbon;
use Log;

class SensorDataController extends BaseApiDataHandler
{

    /**
     * Controller protected by PublicApiAccess middleware
     */
    public function __construct()
    {
        $this->middleware('api.public');
    }


    public function getSensorListData(Request $req){
        //list of possible sensors
        $possible_sensor_list = [ "adpd" , "adxl" , "ecg" , "eda" , "pedometer" , "ppg" , "syncppg" , "temperature" , "bcm", "sqi" ];

        //sensor_list must be an array of strings with at least 1 element in it
        $req->validate([
            'start_date' => 'date_format:Y-m-d H:i:s',
            'end_date' => 'date_format:Y-m-d H:i:s',
            "sensor_list"    => "required|array|min:1",
            "sensor_list.*"  => "required|string|distinct",
        ]);
        //check if all sensor list elements are valid
        foreach($req->input('sensor_list') as $sensor){
            if(!in_array($sensor, $possible_sensor_list)){
                abort(422);
            }
        }
        $pats = $this->allowPatientsOrFail($req);
        $result_array = [];
        $pat_counter = 0;
        foreach($pats as $p) {

            $sensor_data = MongoManager::getDocumentsBetweenUnixDates(Carbon::parse($req->start_date)->timestamp * 1000, Carbon::parse($req->end_date)->timestamp * 1000,$p->inscription_code );
            foreach($sensor_data as $collection_interval){
                foreach($collection_interval["data"] as $sensor_entry){
                    //remove all adpd keys from object if adpd not in sensor list
                    if(!in_array("adpd",$req->input('sensor_list'))){
                        if(array_key_exists("adpd_signal_data",$sensor_entry)){
                            unset($sensor_entry["adpd_signal_data"]);
                        }
                        if(array_key_exists("adpd_dark_data",$sensor_entry)){
                            unset($sensor_entry["adpd_dark_data"]);
                        }
                        if(array_key_exists("adpd_app",$sensor_entry)){
                            unset($sensor_entry["adpd_app"]);
                        }
                        if(array_key_exists("adpd_data_type",$sensor_entry)){
                            unset($sensor_entry["adpd_data_type"]);
                        }
                        if(array_key_exists("adpd_sequence",$sensor_entry)){
                            unset($sensor_entry["adpd_sequence"]);
                        }
                        if(array_key_exists("adpd_sample_n",$sensor_entry)){
                            unset($sensor_entry["adpd_sample_n"]);
                        }
                    }
                    if(!in_array("adxl",$req->input('sensor_list'))){
                        if(array_key_exists("adxl_x",$sensor_entry)){
                            unset($sensor_entry["adxl_x"]);
                        }
                        if(array_key_exists("adxl_y",$sensor_entry)){
                            unset($sensor_entry["adxl_y"]);
                        }
                        if(array_key_exists("adxl_z",$sensor_entry)){
                            unset($sensor_entry["adxl_z"]);
                        }
                    }
                    if(!in_array("bcm",$req->input('sensor_list'))){
                        if(array_key_exists("bcm_imaginary",$sensor_entry)){
                            unset($sensor_entry["bcm_imaginary"]);
                        }
                        if(array_key_exists("bcm_real",$sensor_entry)){
                            unset($sensor_entry["bcm_real"]);
                        }
                        if(array_key_exists("bcm_freq_index",$sensor_entry)){
                            unset($sensor_entry["bcm_freq_index"]);
                        }
                        if(array_key_exists("bcm_impedance_img",$sensor_entry)){
                            unset($sensor_entry["bcm_impedance_img"]);
                        }
                        if(array_key_exists("bcm_impedance_real",$sensor_entry)){
                            unset($sensor_entry["bcm_impedance_real"]);
                        }
                        if(array_key_exists("bcm_real_and_img",$sensor_entry)){
                            unset($sensor_entry["bcm_real_and_img"]);
                        }
                        if(array_key_exists("bcm_impedance_magnitude",$sensor_entry)){
                            unset($sensor_entry["bcm_impedance_magnitude"]);
                        }
                        if(array_key_exists("bcm_impedance_phase",$sensor_entry)){
                            unset($sensor_entry["bcm_impedance_phase"]);
                        }
                    }
                    if(!in_array("ecg",$req->input('sensor_list'))){
                        if(array_key_exists("ecg_data",$sensor_entry)){
                            unset($sensor_entry["ecg_data"]);
                        }
                        if(array_key_exists("ecg_hr",$sensor_entry)){
                            unset($sensor_entry["ecg_hr"]);
                        }
                        if(array_key_exists("ecg_ecg_info",$sensor_entry)){
                            unset($sensor_entry["ecg_ecg_info"]);
                        }
                    }
                    if(!in_array("eda",$req->input('sensor_list'))){
                        if(array_key_exists("eda_real_data",$sensor_entry)){
                            unset($sensor_entry["eda_real_data"]);
                        }
                        if(array_key_exists("eda_imaginary_data",$sensor_entry)){
                            unset($sensor_entry["eda_imaginary_data"]);
                        }
                        if(array_key_exists("eda_impedance_img",$sensor_entry)){
                            unset($sensor_entry["eda_impedance_img"]);
                        }
                        if(array_key_exists("eda_impedance_real",$sensor_entry)){
                            unset($sensor_entry["eda_impedance_real"]);
                        }
                        if(array_key_exists("eda_real_and_img",$sensor_entry)){
                            unset($sensor_entry["eda_real_and_img"]);
                        }
                        if(array_key_exists("eda_impedance_magnitude",$sensor_entry)){
                            unset($sensor_entry["eda_impedance_magnitude"]);
                        }
                        if(array_key_exists("eda_impedance_phase",$sensor_entry)){
                            unset($sensor_entry["eda_impedance_phase"]);
                        }
                        if(array_key_exists("eda_admittance_real",$sensor_entry)){
                            unset($sensor_entry["eda_admittance_real"]);
                        }
                        if(array_key_exists("eda_admittance_img",$sensor_entry)){
                            unset($sensor_entry["eda_admittance_img"]);
                        }
                        if(array_key_exists("eda_admittance_phase",$sensor_entry)){
                            unset($sensor_entry["eda_admittance_phase"]);
                        }
                    }
                    if(!in_array("pedometer",$req->input('sensor_list'))){
                        if(array_key_exists("ped_steps",$sensor_entry)){
                            unset($sensor_entry["ped_steps"]);
                        }
                        if(array_key_exists("ped_reserved",$sensor_entry)){
                            unset($sensor_entry["ped_reserved"]);
                        }
                    }
                    if(!in_array("ppg",$req->input('sensor_list'))){
                        if(array_key_exists("ppg_adpd_lib_state",$sensor_entry)){
                            unset($sensor_entry["ppg_adpd_lib_state"]);
                        }
                        if(array_key_exists("ppg_confidence",$sensor_entry)){
                            unset($sensor_entry["ppg_confidence"]);
                        }
                        if(array_key_exists("ppg_hr",$sensor_entry)){
                            unset($sensor_entry["ppg_hr"]);
                        }
                        if(array_key_exists("ppg_type",$sensor_entry)){
                            unset($sensor_entry["ppg_type"]);
                        }
                        if(array_key_exists("ppg_interval",$sensor_entry)){
                            unset($sensor_entry["ppg_interval"]);
                        }
                    }
                    if(!in_array("sqi",$req->input('sensor_list'))){
                        if(array_key_exists("sqi_sqi",$sensor_entry)){
                            unset($sensor_entry["sqi_sqi"]);
                        }
                        if(array_key_exists("sqi_sqi_slot",$sensor_entry)){
                            unset($sensor_entry["sqi_sqi_slot"]);
                        }
                        if(array_key_exists("sqi_reserved",$sensor_entry)){
                            unset($sensor_entry["sqi_reserved"]);
                        }
                    }
                    if(!in_array("syncppg",$req->input('sensor_list'))){
                        if(array_key_exists("syncppg_sqi",$sensor_entry)){
                            unset($sensor_entry["syncppg_sqi"]);
                        }
                        if(array_key_exists("syncppg_sqi_slot",$sensor_entry)){
                            unset($sensor_entry["syncppg_sqi_slot"]);
                        }
                        if(array_key_exists("syncppg_reserved",$sensor_entry)){
                            unset($sensor_entry["syncppg_reserved"]);
                        }
                    }
                    if(!in_array("temperature",$req->input('sensor_list'))){
                        if(array_key_exists("temp_skin_temperature",$sensor_entry)){
                            unset($sensor_entry["temp_skin_temperature"]);
                        }
                        if(array_key_exists("temp_impedance",$sensor_entry)){
                            unset($sensor_entry["temp_impedance"]);
                        }
                    }
                    
                }
                $patient_collection = new \stdClass();
                $patient_collection->patient  = $pat_counter;
                $patient_collection->data = $collection_interval["data"];
                array_push($result_array, $patient_collection);
                
            }
            $pat_counter = $pat_counter + 1;
        }
        return response()->json( [ 'data' => $result_array ], 200 );

    }

    
    
}
