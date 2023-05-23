<?php

namespace App\Models\Sensors;

use Jenssegers\Mongodb\Eloquent\Model;

class SyncppgData extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'syncppg_data';
   protected $dates = ['timestamp_utc'];

   public const ADXL_TS = 'adxlTs';
   public const X_AXIS = 'x';
   public const Y_AXIS = 'y';
   public const Z_AXIS = 'z';
   public const PPG_DATA = 'ppgData';
   public const TIMESTAMP = 'timestamp_utc';
   public const USER_ID = 'user_db_patient_id';
}
