<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{

    // Medication types
    public const MED_TYPE_CAPSULE = 10;
    public const MED_TYPE_PILL = 20;
    public const MED_TYPE_SYRUP = 30;
    public const MED_TYPE_SUPPOSITORY = 40;
    public const MED_TYPE_LIQUID = 31;
    public const MED_TYPE_TABLET = 21;
    public const MED_TYPE_TOPICAL = 50;
    public const MED_TYPE_DROPS = 51;
    public const MED_TYPE_INHALER = 60;
    public const MED_TYPE_INJECTION = 70;
    public const MED_TYPE_IMPLANT_PATCH = 61;
    public const MED_TYPE_BUCCAL = 22;
    public const MED_TYPE_OTHER = 99;

    //
    protected $table = "medications";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    protected $connection = 'mysql_v_watch';
    protected $fillable = [
        'name', 'pill_dosage','type'
    ];
    //type 1 pill
    //type 2 capsule
    //...
}
