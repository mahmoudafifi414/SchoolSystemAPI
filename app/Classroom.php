<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public function years()
    {
        return $this->belongsToMany('App/Year');
    }
}
