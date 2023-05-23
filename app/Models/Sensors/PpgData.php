<?php

namespace App\Models\Sensors;

use Jenssegers\Mongodb\Eloquent\Model;

class PpgData extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'ppg_data';
   protected $dates = ['timestamp_utc'];

   public const ADPLLIBSTATE = 'adpllibstate';
   public const CONFIDENCE = 'confidence';
   public const HR = 'hr';
   public const TYPE = 'type';
   public const INTERVAL = 'interval';
   public const TIMESTAMP = 'timestamp_utc';
   public const USER_ID = 'user_db_patient_id';
}
