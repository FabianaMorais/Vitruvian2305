<?php

namespace App\Models\NewRegistries;

use Illuminate\Database\Eloquent\Model;

class NewProData extends Model
{
    protected $connection = 'mysql_new_users';
    protected $table = "data_new_pros";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    protected $fillable = [
        'fk_new_user_id', 'full_name', 'address', 'phone'
    ];

    /**
     * Get the user associated with this Professional
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\NewUser', 'fk_new_user_id');
    }
}
