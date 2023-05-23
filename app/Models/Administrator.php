<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrator extends Model
{
    protected $table = "administrators";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fk_user_id', 'full_name',
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * Get the user associated with this Administrator
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'fk_user_id');
    }
}
