<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamUser extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "teams_users";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    protected $fillable = [
        'fk_team_id', 'fk_user_id', 'role', 'access'
    ];

    // ACCESS LEVELS
    public const READ = 9;
    public const WRITE = 10;

    // ROLES
    public const SUBJECT = 0; // AKA: Patients
    public const MEMBER = 1;
    public const LEADER = 2;
    public const PARTICIPANT_ORG = 3; // aka: organization


    public function team()
    {
        return $this->belongsTo('App\Models\Team', 'fk_team_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'fk_user_id');
    }

}
