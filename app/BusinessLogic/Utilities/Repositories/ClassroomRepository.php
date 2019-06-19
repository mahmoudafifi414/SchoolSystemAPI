<?php


namespace App\BusinessLogic\Utilities\Repositories;


use Illuminate\Support\Facades\DB;

class ClassroomRepository
{
    public static function getSemesters($classroomId)
    {
        return DB::table('classrooms')
            ->join('classroom_year', 'classrooms.id', '=', 'classroom_year.classroom_id')
            ->join('year_semester', 'classroom_year.year_id', '=', 'year_semester.year_id')
            ->join('semesters', 'semesters.id', '=', 'year_semester.semester_id')
            ->select('semesters.id', 'semesters.name')
            ->where('classrooms.id', $classroomId)
            ->get();
    }

    public static function getSubjects($classroomId, $yearId)
    {
        return DB::table('subjects')
            ->join('subjects_details', 'subjects.id', '=', 'subjects_details.subject_id')
            ->where([['subjects_details.classroom_id', $classroomId],['subjects_details.year_id',$yearId]])
            ->select('subjects.id','subjects.name','subjects_details.semester_id')
            ->get();
    }
}