<?php


namespace App\BusinessLogic\Utilities\Repositories;


use Illuminate\Support\Facades\DB;

class SubjectRepository
{
    public static function getRelatedTeachers($subjectId)
    {
        return DB::table('users')
            ->join('subjects_teachers', 'users.id', '=', 'subjects_teachers.teacher_id')
            ->select('users.id', 'users.name')
            ->where('subjects_teachers.subject_id', $subjectId)
            ->get();
    }
}