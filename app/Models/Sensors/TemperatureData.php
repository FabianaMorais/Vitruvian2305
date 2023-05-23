<?php

namespace App\Models\Sensors;

use Jenssegers\Mongodb\Eloquent\Model;

class TemperatureData extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'temperature_data';
   protected $dates = ['timestamp_utc'];

   public const SKIN_TEMPERATURE = 'skinTemperature';
   public const AMBIENT_TEMPERATURE = 'ambientTemperature';
   public const TIMESTAMP = 'timestamp_utc';
   public const USER_ID = 'user_db_patient_id';
}
