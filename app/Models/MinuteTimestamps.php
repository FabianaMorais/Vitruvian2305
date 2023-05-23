<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinuteTimestamps extends Model
{
    //
    protected $connection = 'pgsql_v_watch';
    protected $table = "minute_timestamps";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'hour', 'minute',
    ];
}
