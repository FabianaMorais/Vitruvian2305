<?php

namespace App\ServerTools;


use Log;
use App\Models\Users\User;
use Jenssegers\Mongodb\Eloquent\Model;

use DB;


class MongoManager
{
    /* 
        inserts or updates a document's data

     */
    public static function insertData($document_datetime , $use_case, $document_body ,$patient_inscription_code){
        $existing_document = MongoManager::findDocument($document_datetime, $use_case, $patient_inscription_code);
        if($existing_document != null) {
            //update document
            $existing_document["data"] = array_merge($existing_document["data"], $document_body);
            foreach($document_body as $document_data_entry){
                if($document_data_entry == null){
                    Log::debug("trying to update an object with nulls!");
                    Log::debug("new sensor data being added!");
                    Log::debug($document_body);
                    Log::debug("document datetime");
                    Log::debug($document_datetime);
                    Log::debug("updated document");
                    Log::debug($existing_document["data"]);
                    break;
                }
            }
            Log::debug("bucket " . $document_datetime . "has " . count($existing_document["data"]) . "entries of data");
            try {
                DB::connection('mongodb')->table($patient_inscription_code)->where('datetime',$document_datetime)->where('use_case',$use_case)->update(["data" => $existing_document["data"]]);
                return 200;
            }catch(\Exception $e) {
                switch (get_class($e)) {
                    case 'MongoDB\Driver\Exception\RuntimeException':
                        return 409;
                    case 'MongoDB\Driver\Exception\BulkWriteException':
                        return 409;
                    default:
                        return 410;
                  }
                
        
                
            }
        }else{
            //create document
            DB::connection('mongodb')->table($patient_inscription_code)->insert([ "datetime" => $document_datetime, "use_case" => $use_case , "data" => $document_body]);
            return 200;
            
        }
    }

    public static function findDocument($document_datetime, $use_case, $patient_inscription_code){
        $query_result = DB::connection('mongodb')->table($patient_inscription_code)->where('datetime',$document_datetime)->where('use_case',$use_case)->first();
        return $query_result;
    }

    public static function findDocumentById($document_id,$patient_inscription_code){
        $query_result = DB::connection('mongodb')->table($patient_inscription_code)->find($document_id);
        return $query_result;
    }

    public static function getDocumentsBetweenUnixDates($start_timestamp, $end_timestamp, $patient_inscription_code){
        $query_result = DB::connection('mongodb')->table($patient_inscription_code)->where('datetime','<',$end_timestamp)->where('datetime','>',$start_timestamp)->get();
        return $query_result;
    }

    public static function getAllDocumentsForPatient($patient_inscription_code){
        $query_result = DB::connection('mongodb')->table($patient_inscription_code)->get();
        return $query_result;
    }





}