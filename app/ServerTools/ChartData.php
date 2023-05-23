<?php

namespace App\ServerTools;

use App\Models\Sensors\AdpdData;
use App\Models\Sensors\AdxlData;
use App\Models\Sensors\BcmData;
use App\Models\Sensors\EcgData;
use App\Models\Sensors\EdaData;
use App\Models\Sensors\PedometerData;
use App\Models\Sensors\PpgData;
use App\Models\Sensors\SqiData;
use App\Models\Sensors\SyncppgData;
use App\Models\Sensors\TemperatureData;

use App\Models\CrisisEvent;
use App\Models\PatientCrisisEvent;


use App\ServerTools\ChartPointClasses\SimpleChartPoint;
use App\ServerTools\ChartPointClasses\StatisticsChartPoint;


use Carbon\Carbon;

use Log;

    /*
    This class is responsible for fetching and cleaning
    the data which is displayed in web app charts
    */

class ChartData
{
    public const MAX_CHART_SAMPLES = 10;

    /*
    TODO: ADD BACK THE START DATE AND END DATE CONDITIONS TO QUERY
        ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)

    Gets ALL adpd sensor data between 2 timestamps for a patient
    @parameters:
        $start_date : timestamp 
        $end_date : timestamp 
        $patient_id : patient whose data is being queried
    @returns :
        array of adpd sensor data objects
    */
    public static function getAdpdData ( $start_date, $end_date, $patient_id ){
        $all_data = AdpdData::where('user_db_patient_id', $patient_id)
                                ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                ->orderBy('timestamp_utc')
                                ->get();
        $return_data = array();
        if( count( $all_data ) > 0 ){
            foreach( $all_data as $data ){
                // Log::debug("Entry time: " . Carbon::createFromTimestamp($data->timestamp_utc)->format('Y-m-d H:i:s.u'));
                $entry = new SimpleChartPoint( $data->timestamp_utc, $data->signalData );
                array_push( $return_data, $entry );
            }
        }
        return $return_data;
        
    }

    /*
        TODO: ADD BACK THE START DATE AND END DATE CONDITIONS TO QUERY
        ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                
    Gets ALL adxl sensor data between 2 timestamps for a patient
    @parameters:
        $start_date : timestamp 
        $end_date : timestamp 
        $patient_id : patient whose data is being queried
    @returns :
        object with adxl sensor data for each axis with an array of sensor data for that axis
        {
            x_axis: [] array of x axis data,
            y_axis: [] array of y axis data,
            z_axis: [] array of z axis data
        }
    */
    public static function getAdxlData ( $start_date, $end_date, $patient_id ){
        
        Log::debug("start" . $start_date * 1000);
        Log::debug("end" . $end_date * 1000);
        
        $all_data = [];
        $data_results = AdxlData::where('user_db_patient_id', '=', $patient_id)
                            ->where('timestamp_utc', '>', $start_date * 1000)
                            ->where('timestamp_utc', '<', $end_date * 1000)
                            ->orderBy('timestamp_utc')
                            ->get();
        
        
        $x_axis_return_data = array();
        $y_axis_return_data = array();
        $z_axis_return_data = array();

        //create 3 arrays of objects, one for each axis of the accelerometer.
        //the object itself has 2 attributes: x -> timestamp and y->the axis sensor data
        if( count($all_data) > 0 ){
            foreach($all_data as $data){
                $x_axis_entry = new SimpleChartPoint( $data->timestamp_utc, $data->x );
                array_push( $x_axis_return_data, $x_axis_entry );
                $y_axis_entry = new SimpleChartPoint( $data->timestamp_utc, $data->y );
                array_push( $y_axis_return_data, $y_axis_entry );
                $z_axis_entry = new SimpleChartPoint( $data->timestamp_utc, $data->z );
                array_push( $z_axis_return_data, $z_axis_entry );
            }
        }

        $return_data = new \stdClass();
        $return_data->x_axis = $x_axis_return_data;
        $return_data->y_axis = $y_axis_return_data;
        $return_data->z_axis = $z_axis_return_data;

        return $return_data;
    }

    /*
        TODO: ADD BACK THE START DATE AND END DATE CONDITIONS TO QUERY
        ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                
    Gets ALL ecg sensor data between 2 timestamps for a patient
    @parameters:
        $start_date : timestamp 
        $end_date : timestamp 
        $patient_id : patient whose data is being queried
    @returns :
        array of ecg sensor data objects
    */
    public static function getEcgData ( $start_date, $end_date, $patient_id ){
        $all_data = EcgData::where('user_db_patient_id', $patient_id)
                                ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                ->orderBy('timestamp_utc')
                                ->get();

        $ecg_return_data = array();
        $hr_return_data = array();
        if( count( $all_data ) > 0 ){
            foreach( $all_data as $data ){
                $entry = new SimpleChartPoint( $data->timestamp_utc, $data->data );
                array_push( $ecg_return_data, $entry );
                $entry = new SimpleChartPoint( $data->timestamp_utc, $data->hr );
                array_push( $hr_return_data, $entry );
            }
        }
        $return_data = new \stdClass();
        $return_data->ecg = $ecg_return_data;
        $return_data->hrv = $hr_return_data;
        return $return_data;
    }

    /*
         TODO: ADD BACK THE START DATE AND END DATE CONDITIONS TO QUERY
        ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                
    Gets ALL eda sensor data between 2 timestamps for a patient
    @parameters:
        $start_date : timestamp 
        $end_date : timestamp 
        $patient_id : patient whose data is being queried
    @returns :
        object with eda sensor data 
        {
            impedance_magnitude: [] array of impedance magnitude data,
            impedance_phase: [] array of impedance phase data,
            admittance_magnitude: [] array of admittance magnitude data,
            admittance_phase: [] array of admittance phase data
        }
    */
    public static function getEdaData ( $start_date, $end_date, $patient_id ){
        $all_data = [];
         EdaData::where('user_db_patient_id', $patient_id)
                                ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                ->orderBy('timestamp_utc')
                                ->get();
        Log::debug("query finished with results" . count($all_data));
        $realData_return_data = array();
        $imaginaryData_return_data = array();

        //create 42arrays of objects
        if( count($all_data) > 0 ){
            foreach($all_data as $data){
                $realDataEntry = new SimpleChartPoint( $data->timestamp_utc, $data->realData );
                array_push( $realData_return_data, $realDataEntry );
                $imaginaryData_entry = new SimpleChartPoint( $data->timestamp_utc, $data->imaginaryData );
                array_push( $imaginaryData_return_data, $imaginaryData_entry );
                
            }
        }

        $return_data = new \stdClass();
        $return_data->realData = $realData_return_data;
        $return_data->imaginaryData = $imaginaryData_return_data;

        return $return_data;
    }

    /*
        TODO: ADD BACK THE START DATE AND END DATE CONDITIONS TO QUERY
        ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                
    Gets ALL hrv sensor data between 2 timestamps for a patient
    @parameters:
        $start_date : timestamp 
        $end_date : timestamp 
        $patient_id : patient whose data is being queried
    @returns :
        array of hrv sensor data objects
    */
    public static function getHrvData ( $start_date, $end_date, $patient_id ){
        $all_data = EcgData::where('user_db_patient_id', $patient_id)
                                ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                ->orderBy('timestamp_utc')
                                ->get();
        $return_data = array();
        if( count( $all_data ) > 0 ){
            foreach( $all_data as $data ){
                $entry = new SimpleChartPoint( $data->timestamp_utc, $data->rr_interval );
                array_push( $return_data, $entry );
            }
        }
        return $return_data;
    }

    /*
        TODO: ADD BACK THE START DATE AND END DATE CONDITIONS TO QUERY
        ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                
    Gets ALL pedometer sensor data between 2 timestamps for a patient
    @parameters:
        $start_date : timestamp 
        $end_date : timestamp 
        $patient_id : patient whose data is being queried
    @returns :
        array of pedometer sensor data objects
    */
    public static function getPedometerData ( $start_date, $end_date, $patient_id ){
        $all_data = PedometerData::where('user_db_patient_id', $patient_id)
                                ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                ->orderBy('timestamp_utc')
                                ->get();
        $return_data = array();
        if( count( $all_data ) > 0 ){
            foreach( $all_data as $data ){
                $entry = new SimpleChartPoint( $data->timestamp_utc, $data->num_steps );
                array_push( $return_data, $entry );
            }
        }
        return $return_data;
    }

    /*
        TODO: write function
    Gets ALL ppg sensor data between 2 timestamps for a patient
    @parameters:
        $start_date : timestamp 
        $end_date : timestamp 
        $patient_id : patient whose data is being queried
    @returns :
        array of ppg sensor data objects
    */
    public static function getPpgData ( $start_date, $end_date, $patient_id ){
        return true;
    }

    /*
        TODO: write function
    Gets ALL syncppg sensor data between 2 timestamps for a patient
    @parameters:
        $start_date : timestamp 
        $end_date : timestamp 
        $patient_id : patient whose data is being queried
    @returns :
        array of syncppg sensor data objects
    */
    public static function getSyncppgData ( $start_date, $end_date, $patient_id ){
        return true;
    }

    /*
        TODO: write function
    Gets ALL temperature sensor data between 2 timestamps for a patient
    @parameters:
        $start_date : timestamp 
        $end_date : timestamp 
        $patient_id : patient whose data is being queried
    @returns :
        array of temperature sensor data objects
    */
    public static function getTemperatureData ( $start_date, $end_date, $patient_id ){
        $all_data = TemperatureData::where('user_db_patient_id', $patient_id)
                                ->where('timestamp_utc', '>', $start_date * 1000)
                                ->where('timestamp_utc', '<', $end_date * 1000)
                                ->orderBy('timestamp_utc')
                                ->get();
        $return_data = array();
        if( count( $all_data ) > 0 ){
            foreach( $all_data as $data ){
                $entry = new SimpleChartPoint( $data->timestamp_utc, $data->skin_temperature );
                array_push( $return_data, $entry );
            }
        }
        return $return_data;
    }


    /*
    Splits an array of sensor data into equal parts. 
    The maximum number of the equal parts is defined in the constant MAX_CHART_SAMPLES defined on top of this file
    with 3000 and constant defined to 100, we should get an array with 30 indexes. 
        in each index should be an array of sensor data. 
        all indexes should around have the same number of sensor data records
    @parameters:
        $array_to_split : array of sensor data which should be split in equal parts NEEDS TO BE ORDERED BY TS!
    @returns :
        array of the split arrays which should all have about the same size
    */
    public static function splitArrayInEqualParts ( $array_to_split ){
        $total = count($array_to_split);
        //all intervals will have the integer division result
        $records_per_interval = intdiv($total , ChartData::MAX_CHART_SAMPLES );
        //the remainer of the division is then assigned 1 by 1 until it runs out
        $records_remaining = $total % ChartData::MAX_CHART_SAMPLES;

        $loop_counter = 1;
        $split_arrays = array();
        $new_interval_data = array();

        foreach($array_to_split as $record){
            array_push($new_interval_data,$record);
            //if there is a remainer in the division result
            if( $records_remaining > 0 ){
                //if it is the last record of this interval
                if( $loop_counter == $records_per_interval + 1){
                    //add interval array to the result array
                    array_push($split_arrays,$new_interval_data);
                    //reset counter and array for the interval being processed
                    $loop_counter = 0;
                    $new_interval_data = array();
                    //remove 1 from the remaining total
                    $records_remaining = $records_remaining - 1;
                }
            }else{
                if( $loop_counter == $records_per_interval ){
                    //add interval array to the result array
                    array_push($split_arrays,$new_interval_data);
                    //reset counter and array for the interval being processed
                    $loop_counter = 0;
                    $new_interval_data = array();
                }
            }
            $loop_counter = $loop_counter + 1;
        }

        return $split_arrays;
    }

    /*
    Obtains the minimum, maximum, average and initial timestamp values of the sensor data array used as parameter
    these are the values which will be displayed on the charts
    @parameters:
        $sensor_data_interval : an index of the array obtained in the splitArrayInEqualParts() function
    @returns :
        object with:
            - min -> minimum value in the array
            - max -> maximum value in the array
            - avg -> average value in the array
            - initial_ts -> first timestamp value in the array
    */
    public static function getStatisticsForDataInterval ( $interval_data ){
        //control vars
        $tmin = 999999999;
        $tmax = -999999999; //may be changed to 0 if no sensors have negative values
        //sum is stored for the average, sum / count()
        $tsum = 0;
        //min ts is the x value of the first index in the interval data
        $min_ts = $interval_data[0]->getX();
        
        foreach( $interval_data as $data ){
            //if it is higher than max store it as max
            if( $data->getY() > $tmax ) {
                $tmax = $data->getY();
            }
            //if it is lower than min store it as min
            if( $data->getY() < $tmin ) {
                $tmin = $data->getY();
            }
            //add to the total sum
            $tsum = $tsum + $data->getY();
        }

        //calculate average
        $tavg = $tsum / count($interval_data);

        return new StatisticsChartPoint( $tmin, $tmax, $tavg, $min_ts );
    }


    /*

    MAYBE : make 2 layers. 1 for the sensor data with line charts and 1 with 
        TODO: write function
    
    Matches sensor data ready to be displayed with user crisis events to see at which timestamps of the sensor data
    the crisis event happened and save them so they can be displayed in a different color in the frontend
    @parameters:
        

    @returns :
        
    */
    public static function getCrisisEventTimestampForChart ( $time, $chart_first_ts, $chart_stream, $crisis_id, $crisis_pat_id ){
        $crisis_unix_ts = $time->timestamp  - Carbon::parse( $chart_first_ts )->timestamp;
        $distance_to_crisis = 999999999999;
        //go through average stream of data for adpd and see in which point the crisis event fits the best
        //by storing the minimum distance from a point to the crisis event (in module of the number)
        //and corresponding x and y values
        //the idea is to make a new point with same x and y values for a new layer which will be shown
        //on top of others and will represent only crisis events
        foreach( $chart_stream as $data_point ){
            $temp_search = $crisis_unix_ts - $data_point->x;
            if($temp_search < 0){
                $temp_search = -1 * $temp_search;
            } 
            if( $distance_to_crisis > $temp_search) {
                $distance_to_crisis = $temp_search;
                $crisis_index = $data_point->x;
                $crisis_value = $data_point->y;
            }
        }
        
        $return_data = new \stdClass();
        $return_data->crisis_point = new SimpleChartPoint( $crisis_index, $crisis_value ) ;
        $return_data->crisis_name = CrisisEvent::find($crisis_id)->name;
        $return_data->crisis_timestamp = $time->toDateTimeString();
        $return_data->crisis_id = $crisis_pat_id;
        
        return $return_data;
    }





    /*
        Links the splitArrayInEqualParts() and getStatisticsForDataInterval() functions' logic
        @parameters:
            $data_array : an array of sensor data which we want to clean and get statistics from
        @returns :
            $statistics_data: array of statistics data
    */

    public static function cleanAndGetStatisticsForCharts( $data_array){
        $statistics_data = array();
        if( count( $data_array ) > 0) {
            $data_array_in_intervals = ChartData::splitArrayInEqualParts( $data_array );
            foreach( $data_array_in_intervals as $data ) {
                $interval_statistics = ChartData::getStatisticsForDataInterval($data);
                array_push($statistics_data,$interval_statistics);
            }
        }
        return $statistics_data;
    }

    /*
        Splits the statistics_data stream into 3 chart ready data streams for minimum, maximum and average values
        @parameters:
            $statistics_array
        @returns:
            object with {
                minimum_stream: [] array with chart ready data for the minimum values in the stream,
                maximum_stream: [] array with chart ready data for the maximum values in the stream,
                average_stream: [] array with chart ready data for the average values in the stream
            }
    */
    public static function getMinMaxAvgChartStreamsFromStatistics($statistics_array){
        
        $minimum_data_stream = array();
        $maximum_data_stream = array();
        $average_data_stream = array();

        if( count( $statistics_array ) > 0){
            foreach( $statistics_array as $statistics_point ) {
                array_push( $minimum_data_stream, new SimpleChartPoint( $statistics_point->getTimestamp(), $statistics_point->getMin() ) );
                array_push( $maximum_data_stream, new SimpleChartPoint( $statistics_point->getTimestamp(), $statistics_point->getMax() ) );
                array_push( $average_data_stream, new SimpleChartPoint( $statistics_point->getTimestamp(), $statistics_point->getAvg() ) );
            }
        }

        $return_data = new \stdClass();
        $return_data->minimum_stream = $minimum_data_stream;
        $return_data->maximum_stream = $maximum_data_stream;
        $return_data->average_stream = $average_data_stream;
        
        return $return_data;

    }

/*
        obtains the average beats per minute for the hrv  all chart data array
        @parameters:
            $all_hrv_data : array of SimpleChartPoints for all the hrv records
        @returns:
            $average_bpm
    */
    public static function getAverageBpm( $data_array ) {
        $sum = 0;
        foreach( $data_array as $data_point ){
            $sum = $sum + $data_point->getY() ;
        }
        $avg = $sum / count( $data_array );
        return intval($avg);
    }



    /*
    cleans timestamps into numeric values to be used in scatter plot instead

    */
    public static function cleanTimestampsFromChartData( $data_array ) {
        $first_timestamp_string_format = $data_array[0]->getTimestamp();
        $first_unix_ts = Carbon::parse( $data_array[0]->getTimestamp() )->timestamp;
        $last_timestamp_string_format = end( $data_array )->getTimestamp();
        foreach( $data_array as $data_point ){
            $data_point->setTimestamp( Carbon::parse( $data_point->getTimestamp() )->timestamp - $first_unix_ts );
        }
        $return_data = new \stdClass();
        $return_data->chart_data = $data_array;
        $return_data->first_ts = $first_timestamp_string_format;
        $return_data->last_ts = $last_timestamp_string_format;
        return $return_data;
    }


}