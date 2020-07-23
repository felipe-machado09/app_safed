<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarCodes extends Model
{
    function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
