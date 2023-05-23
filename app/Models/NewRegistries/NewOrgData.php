<?php

namespace App\Models\NewRegistries;

use Illuminate\Database\Eloquent\Model;

class NewOrgData extends Model
{
    protected $connection = 'mysql_new_users';
    protected $table = "data_new_orgs";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    protected $fillable = [
        'fk_new_user_id', 'full_name', 'leader_name', 'fiscal_number', 'address', 'phone'
    ];

    /**
     * Get the user associated with this New Organization
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\NewUser', 'fk_new_user_id');
    }
}
