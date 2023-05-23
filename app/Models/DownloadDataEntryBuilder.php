<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Log;

class DownloadDataEntryBuilder extends Model
{
   private $download_data_entry;
   private $has_timestamp;
   private $patient_id;
   private $timestamp;

   public function __construct($patient_id,$sensor_list){
       $this->download_data_entry = new \stdClass();
       $this->sensor_list = $sensor_list;
       $this->patient_id = $patient_id;
       $this->has_timestamp = false;
   }

   public function getDownloadDataEntry(){
        $final_csv_entry = '' . $this->patient_id . ',' . $this->timestamp_utc . ',';
        //add entry if exists or add blank entry if it does not exist but is in sensor list
        if(in_array(1,$this->sensor_list)){
            if(isset($this->download_data_entry->adpd)){
                $final_csv_entry = $final_csv_entry . $this->download_data_entry->adpd;
            }else{
                $final_csv_entry = $final_csv_entry . ',,';
            }
        }
        if(in_array(2,$this->sensor_list)){
            if(isset($this->download_data_entry->adxl)){
                $final_csv_entry = $final_csv_entry . $this->download_data_entry->adxl;
            }else{
                $final_csv_entry = $final_csv_entry . ',,,';
            }
        }
        if(in_array(3,$this->sensor_list)){
            if(isset($this->download_data_entry->ecg)){
                $final_csv_entry = $final_csv_entry . $this->download_data_entry->ecg;
            }else{
                $final_csv_entry = $final_csv_entry . ',,,,';
            }
        }
        if(in_array(4,$this->sensor_list)){
            if(isset($this->download_data_entry->eda)){
                $final_csv_entry = $final_csv_entry . $this->download_data_entry->eda;
            }else{
                $final_csv_entry = $final_csv_entry . ',,,,,,,,';
            }
        }
        if(in_array(5,$this->sensor_list)){
            if(isset($this->download_data_entry->hrv)){
                $final_csv_entry = $final_csv_entry . $this->download_data_entry->hrv;
            }else{
                $final_csv_entry = $final_csv_entry . ',,';
            }
        }
        if(in_array(6,$this->sensor_list)){
            if(isset($this->download_data_entry->pedometer)){
                $final_csv_entry = $final_csv_entry . $this->download_data_entry->pedometer;
            }else{
                $final_csv_entry = $final_csv_entry . ',,,';
            }
        }
        if(in_array(7,$this->sensor_list)){
            if(isset($this->download_data_entry->ppg)){
                $final_csv_entry = $final_csv_entry . $this->download_data_entry->ppg;
            }else{
                $final_csv_entry = $final_csv_entry . ',,,,,';
            }
        }
        if(in_array(8,$this->sensor_list)){
            if(isset($this->download_data_entry->syncppg)){
                $final_csv_entry = $final_csv_entry . $this->download_data_entry->syncppg;
            }else{
                $final_csv_entry = $final_csv_entry . ',,,';
            }
        }
        if(in_array(9,$this->sensor_list)){
            if(isset($this->download_data_entry->temperature)){
                $final_csv_entry = $final_csv_entry . $this->download_data_entry->temperature;
            }else{
                $final_csv_entry = $final_csv_entry . ',,';
            }
        }
        if(isset($this->download_data_entry->pce_occurrence_name)){
            $final_csv_entry = $final_csv_entry . '' . $this->download_data_entry->pce_occurrence_name;
        }
        
        return $final_csv_entry;
   }

   //adpd data builder
   public function addAdpd($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->adpd = '' . $data->adpd_data . ',' . $data->channel;
        return $this;
   }

    //adxl data builder
    public function addAdxl($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->adxl = '' . $data->x . ',' . $data->y . ',' . $data->z . ',';
        return $this;
    }
    //ecg data builder
    public function addEcg($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->ecg = '' . $data->data . ',' . $data->ecg_info . ',' . $data->hr . ',' ;
        return $this;
    }
    //eda data builder
    public function addEda($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->eda = '' . $data->realData . ',' . $data->imaginaryData . ',' ;
        return $this;
    }
    //hrv data builder
    public function addHrv($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->hrv = '' ;
        return $this;
    }

    //pedometer data builder
    public function addPedometer($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->pedometer = '' . $data->num_steps . ',' . $data->algo_status . ',' . $data->reserved . ',';
        return $this;
    }

    //ppg data builder
    public function addPpg($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->ppg = '' . $data->adpdlibstate . ',' . $data->confidence . ',' . $data->hr . ',' . $data->type . ',' . $data->interval . ',' ;
        return $this;
    }

    //Syncppg data builder
    public function addSyncppg($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->syncppg = '' . $data->adxlTs . ',' . $data->x . ',' . $data->y . ',' . $data->z . ',' . $data->ppgTs . ',' . $data->ppgData . ',' ;
        return $this;
    }

    //temperature data builder
    public function addTemperature($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->temperature = '' . $data->skin_temperature . ',' . $data->ambient_temperature . ',' ;
        return $this;
    }

    //bcm data builder
    public function addBcm($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->temperature = '' . $data->realData . ',' . $data->imaginaryData . ',' . $data->frequencyIndex . ',' ;
        return $this;
    }

    //sqi data builder
    public function addSqi($data){
        if(!$this->has_timestamp){
            $this->has_timestamp = true;
            $this->timestamp_utc = $data->timestamp_utc;
        }
        $this->download_data_entry->sqi = '' . $data->sqiSlot . ',' . $data->reserved . ',' . $data->algoStatus . ',' . $data->sqi . ',' ;
        return $this;
    }

    //crisis event data builder
    public function addPatCrisis($crisis_name){
        $this->download_data_entry->pce_occurrence_name = $crisis_name;
        return $this;
    }
}
