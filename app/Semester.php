<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date'];

    public function years()
    {
        return $this->belongsToMany(Year::class, 'year_semester')->withPivot('start_date', 'end_date');
    }
}
