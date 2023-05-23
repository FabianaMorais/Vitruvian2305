<?php

namespace App\Models\Sensors;

use Jenssegers\Mongodb\Eloquent\Model;

class EdaData extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'eda_data';
   protected $dates = ['timestamp_utc'];

   public const REAL_DATA = 'realData';
   public const IMAGINARY_DATA = 'imaginaryData';
   public const TIMESTAMP = 'timestamp_utc';
   public const USER_ID = 'user_db_patient_id';
}
