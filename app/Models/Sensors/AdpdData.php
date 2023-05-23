<?php

namespace App\Models\Sensors;

use Jenssegers\Mongodb\Eloquent\Model;

class AdpdData extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'adpd_data';

   protected $dates = ['timestamp_utc'];


   public const SIGNAL_DATA = 'signalData';
   public const DARK_DATA = 'darkData';
   public const SEQUENCE_NUMBER = 'sequenceNum';
   public const CHANNEL = 'channel';
   public const SAMPLE_NUM = 'sampleNum';
   public const TIMESTAMP = 'timestamp_utc';
   public const USER_ID = 'user_db_patient_id';

}
