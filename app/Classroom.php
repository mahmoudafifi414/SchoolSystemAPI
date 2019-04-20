<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public function years()
    {
        return $this->belongsToMany(Year::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subjects_details', 'classroom_id');
    }
}
