<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'service_id', 'duration', 'price'
    ];

    public function service_data()
    {
    	$this->belongsToMany('App\Service','service_id','id');
    }
}
