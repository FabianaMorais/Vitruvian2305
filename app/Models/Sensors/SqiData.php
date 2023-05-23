<?php

namespace App\Models\Sensors;

use Jenssegers\Mongodb\Eloquent\Model;

class SqiData extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'sqi_data';
   protected $dates = ['timestamp_utc'];

   public const SQI_SLOT = 'sqiSlot';
   public const SEQUENCE_NUMBER = 'sequenceNumber';
   public const RESERVED = 'reserved';
   public const ALGO_STATUS = 'algoStatus';
   public const SQI = 'sqi';
   
   public const TIMESTAMP = 'timestamp_utc';
   public const USER_ID = 'user_db_patient_id';
}
