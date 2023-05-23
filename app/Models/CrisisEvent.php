<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrisisEvent extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "crisis_events";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];
    
    public const FIRST_CRISIS_REPORT_INTERVAL = 3600; //1h
    public const SECOND_CRISIS_REPORT_INTERVAL = 1800; //30m
    public const THIRD_CRISIS_REPORT_INTERVAL = 900; //15m
    public const FOURTH_CRISIS_REPORT_INTERVAL = 300; //5m

}
