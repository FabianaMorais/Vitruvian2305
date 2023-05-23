<?php

namespace App\Models\Sensors;

use Jenssegers\Mongodb\Eloquent\Model;

class PedometerData extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'pedometer_data';
   protected $dates = ['timestamp_utc'];

   public const NUMBER_STEPS = 'numSteps';
   public const ALGO_STATUS = 'algoStatus';
   public const RESERVED = 'reserved';
   public const TIMESTAMP = 'timestamp_utc';
   public const USER_ID = 'user_db_patient_id';
}
