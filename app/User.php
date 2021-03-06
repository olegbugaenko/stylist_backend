<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'salon_name', 'salon_address', 'phonenumber', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'id';

    public function salon()
    {
        return $this->hasOne('App\Salon','user_id');
    }

    //Store some data to pivot table in order to decrease server load while select queries
    public function services()
    {
        return $this->belongsToMany('App\Service')->withPivot('price','duration');
    }

    public function availabilities()
    {
        return $this->hasMany('App\UserAvailability');
    }
}
