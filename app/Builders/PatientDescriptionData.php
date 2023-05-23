<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Model;

use App\ServerTools\MongoManager;
use App\ServerTools\ChartData;
use App\ServerTools\ChartPointClasses\SimpleChartPoint;
use App\ServerTools\ChartPointClasses\StatisticsChartPoint;

//crisis events

use App\Models\CrisisEvent;
use App\Models\PatientCrisisEvent;
use App\Models\MinuteTimestamps;

//medication
use App\Models\Medication;
use App\Models\PatientMedication;
use App\Models\MedTaking;

use App\Models\Patient;
use App\Models\Users\User;

use Session;
use DB;
use Log;
use Carbon\Carbon;

class PatientDescriptionData extends Model
{
    //
    public $patient_description;
    private $patient_id;

    public function __construct($patient_id){
        $this->patient_description = new \stdClass();
        $this->patient_description->patient_id = $patient_id;
        $this->patient_id = $patient_id;
        $this->patient_description->daily_med_schedule = [];
   }

   /*
    runs when a user is selected on the searchbox
    has no parameters
    returns $patient_description object which is composed by:
        patient collected data in the last 24h
        patient crisis events
        patient teams
        patient professionals
        patient medication

        each of these is obtained by a private get function
   */
   public function getInitialPatientDescription($date_string){
        
        $this->getPatientCrisisEventPieChart($date_string);
        $this->getPatientCrisisEventList();    
        // $this->getPatientCollectedData(Carbon::parse($date_string)->addDays(-1)->timestamp * 1000, Carbon::parse($date_string)->timestamp * 1000 , $this->patient_id);

        $this->getPatientCollectedDatav2(Carbon::parse($date_string)->addDays(-1)->timestamp * 1000, Carbon::parse($date_string)->timestamp * 1000 , $this->patient_id);
        
        
        $this->getPatientMedication($date_string);
        
        $this->getPatientMedicationForDay(Carbon::parse($date_string));
        
        $this->getPatientOwners();
        
        $this->getPatientTeams();
        
        return $this;
   }


    public function getPatientCollectedDatav2($start_date, $end_date, $patient_id){
        $patient_code = Patient::find($patient_id)->inscription_code;

        $all_bucket_names = array();

        $all_bucket_names = DB::connection('mongodb')
                                ->table($patient_code)
                                ->select('datetime')
                                ->where('datetime','<',$end_date)
                                ->where('datetime','>',$start_date)
                                ->orderBy('datetime')
                                ->options(['allowDiskUse' => true])
                                ->get();

        //if there are buckets
        if(count($all_bucket_names) > 0 ){
            $this->patient_description->bucket_list = $all_bucket_names;
        }else{
            $this->patient_description->bucket_list = array();
        }

    }

    public function getPatientCollectedData( $start_date, $end_date, $patient_id ){
        $all_crisis_events = PatientCrisisEvent::where('fk_patient_id', $patient_id)->orderBy('crisis_date','ASC')->orderBy('fk_minute_timestamps_id','ASC')->get();
        foreach($all_crisis_events as $ce){
            $ce->crisis_event_name = CrisisEvent::where('id',$ce->fk_crisis_event_id)->first()->name;
            $timestamp = MinuteTimestamps::where('id',$ce->fk_minute_timestamps_id)->first();
            if($timestamp != null) {
                if(strlen($timestamp->hour)==1){
                    $timestamp->hour = '0'.$timestamp->hour;
                }
                if(strlen($timestamp->minute)==1){
                    $timestamp->minute = '0'.$timestamp->minute;
                }
                $ce->crisis_event_time = "" . $timestamp->hour . ":" . $timestamp->minute;
            }else{
                $ce->crisis_event_time = "undefined";
            }
        }

        
        $patient_data = Patient::find($patient_id);
        $sensor_data = MongoManager::getDocumentsBetweenUnixDates($start_date, $end_date,$patient_data->inscription_code );
        
        //initialize arrays for all of the data queried to be divided into the streams we want to chart
        $all_adpd_signal_data = array();
        $all_adpd_dark_data = array();
        $all_adxl_x_axis_data = array();
        $all_adxl_y_axis_data = array();
        $all_adxl_z_axis_data = array();
        $all_ecg_data = array();
        $all_hrv_data = array();
        $all_eda_impedance_magnitude_data = array();
        $all_eda_impedance_phase_data = array();
        $all_eda_admittance_phase_data = array();
        $all_pedometer_data = array();
        $all_skin_temperature_data = array();

        foreach($sensor_data as $collection_interval){
            foreach($collection_interval["data"] as $sensor_entry){
                if(array_key_exists("adpd_signal_data",$sensor_entry)){
                    array_push($all_adpd_signal_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["adpd_signal_data"] ));
                }
                if(array_key_exists("adpd_dark_data",$sensor_entry)){
                    array_push($all_adpd_dark_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["adpd_dark_data"] ));
                }
                if(array_key_exists("adxl_x",$sensor_entry)){
                    array_push($all_adxl_x_axis_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["adxl_x"] ));
                }
                if(array_key_exists("adxl_y",$sensor_entry)){
                    array_push($all_adxl_y_axis_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["adxl_y"] ));
                }
                if(array_key_exists("adxl_z",$sensor_entry)){
                    array_push($all_adxl_z_axis_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["adxl_z"] ));
                }
                if(array_key_exists("ecg_data",$sensor_entry)){
                    array_push($all_ecg_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["ecg_data"] ));
                }
                if(array_key_exists("ecg_hr",$sensor_entry)){
                    array_push($all_hrv_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["ecg_hr"] ));
                }
                if(array_key_exists("eda_impedance_magnitude",$sensor_entry)){
                    array_push($all_eda_impedance_magnitude_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["eda_impedance_magnitude"] ));
                }
                if(array_key_exists("eda_impedance_phase",$sensor_entry)){
                    array_push($all_eda_impedance_phase_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["eda_impedance_phase"] ));
                }
                
                if(array_key_exists("eda_admittance_phase",$sensor_entry)){
                    array_push($all_eda_admittance_phase_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["eda_admittance_phase"] ));
                }
                if(array_key_exists("ped_steps",$sensor_entry)){
                    array_push($all_pedometer_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["ped_steps"] ));
                }
                if(array_key_exists("temp_skin_temperature",$sensor_entry)){
                    array_push($all_skin_temperature_data, new SimpleChartPoint( $sensor_entry["unix_timestamp"],$sensor_entry["temp_skin_temperature"] ));
                }
                
            }
            
        }
        

        

        //declare final data stream which includes statistics for all intervals 
        $statistics_adpd_data = array() ;
        $statistics_adxl_x_axis_data = array() ;
        $statistics_adxl_y_axis_data = array() ;
        $statistics_adxl_z_axis_data = array() ;
        $statistics_ecg_data = array() ;
        $statistics_hrv_data = array() ;
        $statistics_eda_impedance_phase_data = array() ;
        $statistics_eda_impedance_magnitude_data = array() ;
        $statistics_eda_admittance_phase_data = array() ;
        
        $statistics_pedometer_data = array() ;
        $statistics_temperature_data = array() ;

        //split the records in intervals so they are turned into individual points
        //this prevents the charts from having too much data and being impossible to understand
        //all sensor streams are reduced to a maximum of ChartData::MAX_CHART_SAMPLES records

        // adpd
        $statistics_adpd_data = ChartData::cleanAndGetStatisticsForCharts( $all_adpd_signal_data );
        

        // adxl
        $statistics_adxl_x_axis_data = ChartData::cleanAndGetStatisticsForCharts( $all_adxl_x_axis_data );
        $statistics_adxl_y_axis_data = ChartData::cleanAndGetStatisticsForCharts( $all_adxl_y_axis_data );
        $statistics_adxl_z_axis_data = ChartData::cleanAndGetStatisticsForCharts( $all_adxl_z_axis_data );
        
        //ecg
        $statistics_ecg_data = ChartData::cleanAndGetStatisticsForCharts( $all_ecg_data );

        //hrv
        $statistics_hrv_data = ChartData::cleanAndGetStatisticsForCharts( $all_hrv_data );

        //EDA
        $statistics_eda_impedance_phase_data = ChartData::cleanAndGetStatisticsForCharts( $all_eda_impedance_magnitude_data );
        $statistics_eda_impedance_magnitude_data = ChartData::cleanAndGetStatisticsForCharts( $all_eda_impedance_phase_data );
        $statistics_eda_admittance_phase_data = ChartData::cleanAndGetStatisticsForCharts( $all_eda_admittance_phase_data );
        

        //pedometer
        $statistics_pedometer_data = ChartData::cleanAndGetStatisticsForCharts( $all_pedometer_data );

        //temperature
        $statistics_temperature_data = ChartData::cleanAndGetStatisticsForCharts( $all_skin_temperature_data );
        

        
        //TODO: add the clean ts function to each statistics_data_stream to make them numeric while saving first ts and last ts in string format into vars
        if( count( $statistics_adpd_data) > 0 ){
            $data = ChartData::cleanTimestampsFromChartData($statistics_adpd_data);
            $statistics_adpd_data = $data->chart_data;
            $adpd_first_ts_string = Carbon::createFromTimestampMs($data->first_ts)->format('Y-m-d H:i:s.u');
            $adpd_last_ts_string = Carbon::createFromTimestampMs($data->last_ts)->format('Y-m-d H:i:s.u');
            $this->patient_description->adpd_first_ts_label = $adpd_first_ts_string;
            $this->patient_description->adpd_last_ts_label = $adpd_last_ts_string;
        }
        
        if( count( $statistics_ecg_data) > 0 ){
            $data = ChartData::cleanTimestampsFromChartData($statistics_ecg_data);
            $statistics_ecg_data = $data->chart_data;
            $ecg_first_ts_string = Carbon::createFromTimestampMs($data->first_ts)->format('Y-m-d H:i:s.u');
            $ecg_last_ts_string = Carbon::createFromTimestampMs($data->last_ts)->format('Y-m-d H:i:s.u');
            $this->patient_description->ecg_first_ts_label = $ecg_first_ts_string;
            $this->patient_description->ecg_last_ts_label = $ecg_last_ts_string;
        }

        if( count( $statistics_eda_impedance_phase_data) > 0 ){
            $data = ChartData::cleanTimestampsFromChartData($statistics_eda_impedance_phase_data);
            $statistics_eda_impedance_phase_data = $data->chart_data;
            $eda_impedance_phase_first_ts_string = Carbon::createFromTimestampMs($data->first_ts)->format('Y-m-d H:i:s.u');
            $eda_impedance_phase_last_ts_string = Carbon::createFromTimestampMs($data->last_ts)->format('Y-m-d H:i:s.u');
            $this->patient_description->eda_impedance_phase_first_ts_label = $eda_impedance_phase_first_ts_string;
            $this->patient_description->eda_impedance_phase_last_ts_label = $eda_impedance_phase_last_ts_string;
        }
        if( count( $statistics_eda_impedance_magnitude_data) > 0 ){
            $data = ChartData::cleanTimestampsFromChartData($statistics_eda_impedance_magnitude_data);
            $statistics_eda_impedance_magnitude_data = $data->chart_data;
            $eda_impedance_magnitude_first_ts_string = Carbon::createFromTimestampMs($data->first_ts)->format('Y-m-d H:i:s.u');
            $eda_impedance_magnitude_last_ts_string = Carbon::createFromTimestampMs($data->last_ts)->format('Y-m-d H:i:s.u');
            $this->patient_description->eda_impedance_magnitude_first_ts_label = $eda_impedance_magnitude_first_ts_string;
            $this->patient_description->eda_impedance_magnitude_last_ts_label = $eda_impedance_magnitude_last_ts_string;
        }
        if( count( $statistics_eda_admittance_phase_data) > 0 ){
            $data = ChartData::cleanTimestampsFromChartData($statistics_eda_admittance_phase_data);
            $statistics_eda_admittance_phase_data = $data->chart_data;
            $eda_admittance_phase_first_ts_string = Carbon::createFromTimestampMsUTC($data->first_ts)->format('Y-m-d H:i:s.u');
            $eda_admittance_phase_last_ts_string = Carbon::createFromTimestampMsUTC($data->last_ts)->format('Y-m-d H:i:s.u');
            $this->patient_description->eda_admittance_phase_first_ts_label = $eda_admittance_phase_first_ts_string;
            $this->patient_description->eda_admittance_phase_last_ts_label = $eda_admittance_phase_last_ts_string;
        }
        


        if( count( $statistics_hrv_data) > 0 ){
            $data = ChartData::cleanTimestampsFromChartData($statistics_hrv_data);
            $statistics_hrv_data = $data->chart_data;
            $hrv_first_ts_string = Carbon::createFromTimestamp($data->first_ts)->format('Y-m-d H:i:s.u');
            $hrv_last_ts_string = Carbon::createFromTimestamp($data->last_ts)->format('Y-m-d H:i:s.u');
            $this->patient_description->hrv_first_ts_label = $hrv_first_ts_string;
            $this->patient_description->hrv_last_ts_label = $hrv_last_ts_string;
        }

        if( count( $statistics_temperature_data) > 0 ){
            $data = ChartData::cleanTimestampsFromChartData($statistics_temperature_data);
            $statistics_temperature_data = $data->chart_data;
            $temperature_first_ts_string = Carbon::createFromTimestamp($data->first_ts)->format('Y-m-d H:i:s.u');
            $temperature_last_ts_string = Carbon::createFromTimestamp($data->last_ts)->format('Y-m-d H:i:s.u');
            $this->patient_description->temperature_first_ts_label = $temperature_first_ts_string;
            $this->patient_description->temperature_last_ts_label = $temperature_last_ts_string;
        }
        

        
        //get adpd data ready for charts and add them to $this->patient_description object
        $this->patient_description->adpd_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_adpd_data );
        

        //get adxl data ready for charts and add them to $this->patient_description object
        $this->patient_description->adxl_x_axis_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_adxl_x_axis_data );
        $this->patient_description->adxl_y_axis_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_adxl_y_axis_data );
        $this->patient_description->adxl_z_axis_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_adxl_z_axis_data );
        

        //get ecg data ready for charts and add them to $this->patient_description object
        $this->patient_description->ecg_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_ecg_data );

        //get eda data ready for charts and add them to $this->patient_description object
        $this->patient_description->eda_impedance_phase_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_eda_impedance_phase_data );
        $this->patient_description->eda_impedance_magnitude_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_eda_impedance_magnitude_data );
        $this->patient_description->eda_admittance_phase_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_eda_admittance_phase_data );
        

        //get hrv data ready for charts and add them to $this->patient_description object
        $this->patient_description->hrv_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_hrv_data );

        //get pedometer data ready for charts and add them to $this->patient_description object
        $this->patient_description->pedometer_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_pedometer_data );

        //get temperature data ready for charts and add them to $this->patient_description object
        $this->patient_description->temperature_data_for_charts = ChartData::getMinMaxAvgChartStreamsFromStatistics( $statistics_temperature_data );

        //get average bpm from all_hrv_data stream
        if( count($all_hrv_data) > 0 ){
            $this->patient_description->average_bpm = ChartData::getAverageBpm( $all_hrv_data );
        }

        //crisis events
        $crisis_event_list = $all_crisis_events;
        
        $adpd_crisis = array();
        $adpd_crisis_desc = array();
        $ecg_crisis = array() ;
        $ecg_crisis_desc = array();
        $hrv_crisis = array() ;
        $hrv_crisis_desc = array();
        $eda_impedance_phase_crisis = array() ;
        $eda_impedance_phase_crisis_desc = array() ;
        $eda_impedance_magnitude_crisis = array() ;
        $eda_impedance_magnitude_crisis_desc = array() ;
        $eda_admittance_phase_crisis = array() ;
        $eda_admittance_phase_crisis_desc = array() ;
        
        $pedometer_crisis = array() ;
        $pedometer_crisis_desc = array() ;
        $temperature_crisis = array() ;
        $temperature_crisis_desc = array() ;
        foreach($crisis_event_list as $crisis_event){
            if( $crisis_event->crisis_event_time != 'undefined' ) {
                $time = Carbon::parse('' . $crisis_event->crisis_date .' ' . $crisis_event->crisis_event_time );
                //check if $time is between adpd first ts and last ts_label
                if( count( $this->patient_description->adpd_data_for_charts->average_stream ) > 0 && $time > Carbon::parse( $this->patient_description->adpd_first_ts_label ) && $time < Carbon::parse( $this->patient_description->adpd_last_ts_label )){
                    $data = ChartData::getCrisisEventTimestampForChart( $time, 
                                                                $this->patient_description->adpd_first_ts_label, 
                                                                $this->patient_description->adpd_data_for_charts->average_stream,
                                                                $crisis_event->fk_crisis_event_id, $crisis_event->id );
                    array_push( $adpd_crisis, $data->crisis_point );
                    $crisis_info = new \stdClass();
                    $crisis_info->name = $data->crisis_name;
                    $crisis_info->timestamp = $data->crisis_timestamp;
                    array_push( $adpd_crisis_desc, $crisis_info );
                }
                if( count( $this->patient_description->ecg_data_for_charts->average_stream ) > 0 && $time > Carbon::parse( $this->patient_description->ecg_first_ts_label ) && $time < Carbon::parse( $this->patient_description->ecg_last_ts_label )){
                    $data = ChartData::getCrisisEventTimestampForChart( $time, 
                                                                $this->patient_description->ecg_first_ts_label, 
                                                                $this->patient_description->ecg_data_for_charts->average_stream ,
                                                                $crisis_event->fk_crisis_event_id, $crisis_event->id );
                    array_push( $ecg_crisis, $data->crisis_point );
                    $crisis_info = new \stdClass();
                    $crisis_info->name = $data->crisis_name;
                    $crisis_info->timestamp = $data->crisis_timestamp;
                    array_push( $ecg_crisis_desc, $crisis_info );
                }
                if( count( $this->patient_description->eda_impedance_phase_data_for_charts->average_stream ) > 0 && $time > Carbon::parse( $this->patient_description->eda_impedance_phase_first_ts_label ) && $time < Carbon::parse( $this->patient_description->eda_impedance_phase_last_ts_label )){
                    $data = ChartData::getCrisisEventTimestampForChart( $time, 
                                                                $this->patient_description->eda_impedance_phase_first_ts_label, 
                                                                $this->patient_description->eda_impedance_phase_data_for_charts->average_stream,
                                                                $crisis_event->fk_crisis_event_id, $crisis_event->id );
                    array_push( $eda_impedance_phase_crisis, $data->crisis_point );
                    $crisis_info = new \stdClass();
                    $crisis_info->name = $data->crisis_name;
                    $crisis_info->timestamp = $data->crisis_timestamp;
                    array_push( $eda_impedance_phase_crisis_desc, $crisis_info );
                }
                if( count( $this->patient_description->eda_impedance_magnitude_data_for_charts->average_stream ) > 0 && $time > Carbon::parse( $this->patient_description->eda_impedance_magnitude_first_ts_label ) && $time < Carbon::parse( $this->patient_description->eda_impedance_magnitude_last_ts_label )){
                    $data = ChartData::getCrisisEventTimestampForChart( $time, 
                                                                $this->patient_description->eda_impedance_magnitude_first_ts_label, 
                                                                $this->patient_description->eda_impedance_magnitude_data_for_charts->average_stream,
                                                                $crisis_event->fk_crisis_event_id, $crisis_event->id );
                    array_push( $eda_impedance_magnitude_crisis, $data->crisis_point );
                    $crisis_info = new \stdClass();
                    $crisis_info->name = $data->crisis_name;
                    $crisis_info->timestamp = $data->crisis_timestamp;
                    array_push( $eda_impedance_magnitude_crisis_desc, $crisis_info );
                }
                if( count( $this->patient_description->eda_admittance_phase_data_for_charts->average_stream ) > 0 && $time > Carbon::parse( $this->patient_description->eda_admittance_phase_first_ts_label ) && $time < Carbon::parse( $this->patient_description->eda_admittance_phase_last_ts_label )){
                    $data = ChartData::getCrisisEventTimestampForChart( $time, 
                                                                $this->patient_description->eda_admittance_phase_first_ts_label, 
                                                                $this->patient_description->eda_admittance_phase_data_for_charts->average_stream,
                                                                $crisis_event->fk_crisis_event_id, $crisis_event->id );
                    array_push( $eda_admittance_phase_crisis, $data->crisis_point );
                    $crisis_info = new \stdClass();
                    $crisis_info->name = $data->crisis_name;
                    $crisis_info->timestamp = $data->crisis_timestamp;
                    array_push( $eda_admittance_phase_crisis_desc, $crisis_info );
                }
                

                if( count( $this->patient_description->hrv_data_for_charts->average_stream ) > 0 && $time > Carbon::parse( $this->patient_description->hrv_first_ts_label ) && $time < Carbon::parse( $this->patient_description->hrv_last_ts_label )){
                    $data = ChartData::getCrisisEventTimestampForChart( $time, 
                                                                $this->patient_description->hrv_first_ts_label, 
                                                                $this->patient_description->hrv_data_for_charts->average_stream,
                                                                $crisis_event->fk_crisis_event_id, $crisis_event->id );
                    array_push( $hrv_crisis, $data->crisis_point );
                    $crisis_info = new \stdClass();
                    $crisis_info->name = $data->crisis_name;
                    $crisis_info->timestamp = $data->crisis_timestamp;
                    array_push( $hrv_crisis_desc, $crisis_info );
                }

                if( count( $this->patient_description->temperature_data_for_charts->average_stream ) > 0 && $time > Carbon::parse( $this->patient_description->temperature_first_ts_label ) && $time < Carbon::parse( $this->patient_description->temperature_last_ts_label )){
                    $data = ChartData::getCrisisEventTimestampForChart( $time, 
                                                                $this->patient_description->temperature_first_ts_label, 
                                                                $this->patient_description->temperature_data_for_charts->average_stream,
                                                                $crisis_event->fk_crisis_event_id, $crisis_event->id );
                    array_push( $temperature_crisis, $data->crisis_point );
                    $crisis_info = new \stdClass();
                    $crisis_info->name = $data->crisis_name;
                    $crisis_info->timestamp = $data->crisis_timestamp;
                    array_push( $temperature_crisis_desc, $crisis_info );
                }
                // if($time > Carbon::parse( $this->patient_description->pedometer_first_ts_label ) && $time < Carbon::parse( $this->patient_description->pedometer_last_ts_label )){
                //     array_push( $pedometer_crisis, ChartData::getCrisisEventTimestampForChart( $time, 
                //                                                 $this->patient_description->pedometer_first_ts_label, 
                //                                                 $this->patient_description->pedometer_data_for_charts->average_stream ));
                // }
                
            } 
        }
        $this->patient_description->adpd_data_for_charts->crisis_stream = $adpd_crisis;
        $this->patient_description->ecg_data_for_charts->crisis_stream = $ecg_crisis;
        $this->patient_description->eda_impedance_phase_data_for_charts->crisis_stream = $eda_impedance_phase_crisis;
        $this->patient_description->eda_impedance_magnitude_data_for_charts->crisis_stream = $eda_impedance_magnitude_crisis;
        $this->patient_description->eda_admittance_phase_data_for_charts->crisis_stream = $eda_admittance_phase_crisis;
        
        $this->patient_description->hrv_data_for_charts->crisis_stream = $hrv_crisis;
        $this->patient_description->temperature_data_for_charts->crisis_stream = $temperature_crisis;
        

        $this->patient_description->adpd_data_for_charts->crisis_stream_desc = $adpd_crisis_desc;
        $this->patient_description->ecg_data_for_charts->crisis_stream_desc = $ecg_crisis_desc;
        $this->patient_description->eda_impedance_phase_data_for_charts->crisis_stream_desc = $eda_impedance_phase_crisis_desc;
        $this->patient_description->eda_impedance_magnitude_data_for_charts->crisis_stream_desc = $eda_impedance_magnitude_crisis_desc;
        $this->patient_description->eda_admittance_phase_data_for_charts->crisis_stream_desc = $eda_admittance_phase_crisis_desc;
        
        $this->patient_description->hrv_data_for_charts->crisis_stream_desc = $hrv_crisis_desc;
        $this->patient_description->temperature_data_for_charts->crisis_stream_desc = $temperature_crisis_desc;
        
   }

    private function getPatientCrisisEventPieChart($date_string){
        //get data for user crisis event charts
        $patient_crisis_event_count_today = PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->where('crisis_date','>=', Carbon::Today())->count();
        $now = Carbon::parse($date_string);
        $tsqueryresult = MinuteTimestamps::where('minute',$now->minute)->where('hour',$now->hour)->first()->id;
        $patient_crisis_event_count_last_24h = PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->where('crisis_date','=', Carbon::Today()->add(-1,'day'))->where('fk_minute_timestamps_id','>',$tsqueryresult)->count() + $patient_crisis_event_count_today;
        $patient_crisis_event_count_last_week = PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->where('crisis_date','=', Carbon::Today()->add(-7,'day'))->where('fk_minute_timestamps_id','>',$tsqueryresult)->count() + PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->where('crisis_date','>', Carbon::Today()->add(-7,'day'))->count() - $patient_crisis_event_count_last_24h ;
        $patient_crisis_event_count_last_30days = PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->where('crisis_date','=', Carbon::Today()->add(-30,'day'))->where('fk_minute_timestamps_id','>',$tsqueryresult)->count() + PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->where('crisis_date','>', Carbon::Today()->add(-30,'day'))->count() - $patient_crisis_event_count_last_week -  $patient_crisis_event_count_last_24h;
        $patient_crisis_event_count_last_year = PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->where('crisis_date','=', Carbon::Today()->add(-365,'day'))->where('fk_minute_timestamps_id','>',$tsqueryresult)->count() + PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->where('crisis_date','>', Carbon::Today()->add(-365,'day'))->count() - $patient_crisis_event_count_last_30days - $patient_crisis_event_count_last_week -  $patient_crisis_event_count_last_24h;
        $patient_crisis_event_total_last_year = $patient_crisis_event_count_last_24h + $patient_crisis_event_count_last_week + $patient_crisis_event_count_last_30days + $patient_crisis_event_count_last_year;
        $patient_crisis_event_count_others = PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->count() - $patient_crisis_event_total_last_year;
        //crisis events last 24h , not included in higher hierarchy (event today is shown in last 24h and not in last week, month or year)
        $this->patient_description->c_e_l_24h = $patient_crisis_event_count_last_24h;
        //crisis events last week
        $this->patient_description->c_e_l_7d = $patient_crisis_event_count_last_week;
        //crisis events last month
        $this->patient_description->c_e_l_30d = $patient_crisis_event_count_last_30days;
        //crisis events last year
        $this->patient_description->c_e_l_365d = $patient_crisis_event_count_last_year;
        //crisis events total excluding last year
        $this->patient_description->c_e_total_wo_l_y = $patient_crisis_event_count_others;
    }

    private function getPatientCrisisEventList(){
        $all_crisis_events = PatientCrisisEvent::where('fk_patient_id',$this->patient_id)->orderBy('crisis_date','DESC')->orderBy('fk_minute_timestamps_id','DESC')->get();
        foreach($all_crisis_events as $ce){
            $ce->crisis_event_name = CrisisEvent::where('id',$ce->fk_crisis_event_id)->first()->name;
            $timestamp = MinuteTimestamps::where('id',$ce->fk_minute_timestamps_id)->first();
            if($timestamp != null) {
                if(strlen($timestamp->hour)==1){
                    $timestamp->hour = '0'.$timestamp->hour;
                }
                if(strlen($timestamp->minute)==1){
                    $timestamp->minute = '0'.$timestamp->minute;
                }
                $ce->crisis_event_time = "" . $timestamp->hour . ":" . $timestamp->minute;
            }else{
                $ce->crisis_event_time = "undefined";
            }
            
        }
        $this->patient_description->crisis_event_list = $all_crisis_events;
    }

    private function getPatientMedication($date_string){


        $this->patient_description->patient_medication = array(); // TODO: REVIEW THIS!!! - also, rever inicialização de outras vars

        //complete list of patient medication without schedule
        $patient_medication = [];
        // user medication
        $med_query_results = PatientMedication::where('fk_patient_id',$this->patient_id)->where('start_date','<',Carbon::parse($date_string))->get();
        //final patient medication schedule
        $weekly_medication_schedule = [];
        for($day_nr = 0; $day_nr < 7; $day_nr ++){
            $patient_medication_schedule = [];
            foreach($med_query_results as $pat_med){
                if($pat_med->end_date == null or $pat_med->end_date > Carbon::parse($date_string)){
                    //get dosage and name of med from ID and store in var
                    $name = Medication::find($pat_med->fk_medication_id)->name;
                    $dosage = Medication::find($pat_med->fk_medication_id)->pill_dosage;
                    if(!in_array(''.$name.' ('.$dosage.'mg)',$patient_medication) ){
                        array_push($patient_medication,''.$name.' ('.$dosage.'mg)');
                    }

                    //add patient medication list to patient description object
                    $this->patient_description->patient_medication = $patient_medication;
                    
                    //deconstruct medication schedule into an array with single taking entries
                    foreach($pat_med->scheduled_intakes as $key=>$scheduled_intake){
                        if(Carbon::parse($date_string) > $pat_med->start_date && (Carbon::parse($date_string) < $pat_med->end_date || $pat_med->end_date == null)){
                            if(Carbon::parse($date_string)->addDays($day_nr)->diffInDays($pat_med->start_date) % $pat_med->periodicity == 0){
                                //object for a single medication schedule entry
                                $med_schedule_entry = new \stdClass();
                                //create a string with quantity, name and dosage i.e. 2 Paracetamol (500mg)
                                $med_schedule_entry->medication = ''. $pat_med->nr_of_pills_each_intake[$key].' '.$name.' ('.$dosage.'mg)';
                                $med_schedule_entry->time = $scheduled_intake;
                                array_push($patient_medication_schedule,$med_schedule_entry);
                            }
                        }
                            
                            
                    
                    }
                }
            }
            $offsets_to_remove = [];
            for($i=0;$i<count($patient_medication_schedule);$i++){
                for($j=$i+1; $j<count($patient_medication_schedule);$j++){
                    if($patient_medication_schedule[$i]->time == $patient_medication_schedule[$j]->time ){
                        $patient_medication_schedule[$i]->medication = $patient_medication_schedule[$i]->medication . '<br>' .$patient_medication_schedule[$j]->medication;
                        if(!in_array($j,$offsets_to_remove)){
                            array_push($offsets_to_remove,$j);    
                        }
                    }
                }
            }
            
            rsort($offsets_to_remove);
            foreach($offsets_to_remove as $offset){
                array_splice($patient_medication_schedule, $offset, 1);
            }
            
            //order patient medication schedule entries by the timestamp
            for($i=0;$i<count($patient_medication_schedule);$i++){
                for($j=$i+1;$j<count($patient_medication_schedule);$j++){
                    if($patient_medication_schedule[$i]->time > $patient_medication_schedule[$j]->time){
                        $temp_sort_var = $patient_medication_schedule[$i];
                        $patient_medication_schedule[$i] = $patient_medication_schedule[$j];
                        $patient_medication_schedule[$j] = $temp_sort_var;
                    }
                }
            }
            
            array_push($weekly_medication_schedule,$patient_medication_schedule);
        }   
        $max_array_length = 0;
        for($i = 0; $i < 7; $i++){
            if(count($weekly_medication_schedule[$i]) > $max_array_length){
                $max_array_length = count($weekly_medication_schedule[$i]);
            }
        }
       
        
        foreach($weekly_medication_schedule as $patient_medication_schedule){
            //get timestamps for medication schedule instead of ts ids
            foreach($patient_medication_schedule as $pat_med){
                if($pat_med->medication != ''){
                    //if <10, add a 0 before to the minutes field
                    $clean_taking_mins = MinuteTimestamps::find($pat_med->time)->minute;
                    if(strlen($clean_taking_mins)==1){
                        $clean_taking_mins = '0'.$clean_taking_mins;
                    }
                    $pat_med->time = ''.MinuteTimestamps::find($pat_med->time)->hour.':'.$clean_taking_mins.'h';
                }
            }
        }
        //add patient medication schedule to patient description object
        $this->patient_description->weekly_medication_schedule = $weekly_medication_schedule;
    }

    

    //gets all medication takings for a certain day
    public function getPatientMedicationForDay($date_to_query){
        $med_query_results = 
            PatientMedication::where('fk_patient_id', $this->patient_id )
            ->where('start_date','<=',$date_to_query)
            ->where('fk_patient_id', $this->patient_id )
            ->where(function($query) use ($date_to_query) {
                $query->where('end_date', null)
                ->orWhere('end_date', '>=', $date_to_query);
            })->get();
        $daily_med_schedule = [];
        if(count($med_query_results) == 0){
            return false;
        }
        foreach($med_query_results as $pat_med){
            if($pat_med->end_date > $date_to_query || $pat_med->end_date == null){
                //if it is a taking day, get data ready for the response
                if($pat_med->periodicity == 1 || $date_to_query->diffInDays($pat_med->start_date) % $pat_med->periodicity == 0){
                    $med = Medication::find($pat_med->fk_medication_id);
                    $name = $med->name;
                    $dosage = $med->pill_dosage;
                    $type = $med->type;
                    for($i=0;$i<count($pat_med->scheduled_intakes);$i++){
                        $med_schedule_entry = new \stdClass();
                        $med_schedule_entry->pat_med_id = $pat_med->id;
                        $med_schedule_entry->name = $name;
                        $med_schedule_entry->dosage = $dosage;
                        $med_schedule_entry->type = $type;
                        $med_schedule_entry->prescribed_by_professional = $pat_med->prescribed_by_professional;
                        $time = MinuteTimestamps::find($pat_med->scheduled_intakes[$i]);
                        if( $time->hour < 10){
                            $time->hour = '0'. $time->hour;
                        }
                        if( $time->minute < 10){
                            $time->minute = '0'. $time->minute;
                        }
                        $med_schedule_entry->hour = $time->hour;
                        $med_schedule_entry->minute = $time->minute;
                        $med_schedule_entry->number_of_pills = intval($pat_med->nr_of_pills_each_intake[$i]);
                        if($pat_med->notes != null){
                            $med_schedule_entry->notes = $pat_med->notes;
                        }else{
                            $med_schedule_entry->notes = '';
                        }
                        $med_schedule_entry->id = $pat_med->id;
                        array_push($daily_med_schedule,$med_schedule_entry);
                    }
                }
            }
        }
        
        usort($daily_med_schedule, function ($object1, $object2) {
            if($object1->hour == $object2->hour) {
                return $object1->minute > $object2->minute ? 1 : -1;
            }else{
                return $object1->hour > $object2->hour ? 1 : -1;
            }
            
        });
        
        $this->patient_description->daily_med_schedule = $daily_med_schedule; 
    }

    
    private function getPatientOwners(){
        $this->patient_description->professionals = [];
        $patient = Patient::where('id',$this->patient_id)->get()->first();
        
        $professional_previews = [];
        foreach($patient->getOwners() as $owner){
            array_push($professional_previews, $owner->getUIData());
        }
        $this->patient_description->professionals = $professional_previews;
    }
    private function getPatientTeams(){
        $this->patient_description->teams = [];
        $patient = Patient::where('id',$this->patient_id)->get()->first();
        $team_previews = [];
        foreach($patient->getTeams() as $team){
            array_push($team_previews,$team->getTeamCardUI());
        }
        $this->patient_description->teams = $team_previews;
    }








}
