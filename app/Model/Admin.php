<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    protected $fillable = [
        'login_id','v_first_name', 'v_last_name', 'v_email', 'v_phone',
    ];
}
