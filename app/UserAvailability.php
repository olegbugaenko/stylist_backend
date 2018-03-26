<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAvailability extends Model
{
    //
    protected $fillable = ['user_id','day_id','from','to','is_free'];


}
