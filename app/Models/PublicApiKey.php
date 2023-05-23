<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicApiKey extends Model
{
    protected $table = "public_api_keys";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fk_user_id', 'key',
    ];

    /**
     * @return User: the User associated with this Public API key
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'fk_user_id');
    }
}
