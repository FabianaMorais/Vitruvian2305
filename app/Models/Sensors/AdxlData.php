<?php

namespace App\Models\Sensors;

use Jenssegers\Mongodb\Eloquent\Model;

class AdxlData extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'adxl_data';
   protected $dates = ['timestamp_utc'];

   public const X_AXIS = 'x';
   public const Y_AXIS = 'y';
   public const Z_AXIS = 'z';
   public const TIMESTAMP = 'timestamp_utc';
   public const USER_ID = 'user_db_patient_id';

}
