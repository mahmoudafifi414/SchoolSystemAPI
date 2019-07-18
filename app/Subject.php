<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subjects_teachers', 'subject_id', 'teacher_id');
    }
}
