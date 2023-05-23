<?php

namespace App\Models\Sensors;

use Jenssegers\Mongodb\Eloquent\Model;

class EcgData extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'ecg_data';
   protected $dates = ['timestamp_utc'];

   public const DATA = 'data';
   public const ECG_INFO = 'ecg_info';
   public const HR = 'hr';
   public const TIMESTAMP = 'timestamp_utc';
   public const USER_ID = 'user_db_patient_id';
}
