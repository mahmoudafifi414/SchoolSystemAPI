<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date'];

    public function semesters()
    {
        return $this->belongsToMany(Semester::class, 'year_semester')->withPivot('start_date', 'end_date');
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'users_students_details');
    }
}
