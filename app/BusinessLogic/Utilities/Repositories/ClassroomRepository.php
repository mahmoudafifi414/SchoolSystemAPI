<?php


namespace App\BusinessLogic\Utilities\Repositories;


use App\Subject;
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
            ->where([['subjects_details.classroom_id', $classroomId], ['subjects_details.year_id', $yearId]])
            ->select('subjects.id', 'subjects.name', 'subjects_details.semester_id')
            ->get();
    }

    public static function getSubjectsAfterSync($classroomId, $yearId, $subjectIds, $semesterId)
    {
        return DB::table('subjects')
            ->join('subjects_details', 'subjects.id', '=', 'subjects_details.subject_id')
            ->where(
                [
                    ['subjects_details.classroom_id', $classroomId], ['subjects_details.year_id', $yearId],
                    ['subjects_details.semester_id', $semesterId]
                ])
            ->whereIn('subjects_details.subject_id', $subjectIds)
            ->select('subjects.id', 'subjects.name', 'subjects_details.semester_id')
            ->get();
    }

    public static function deleteSubjectsInDetachSemester($classroomId, $yearId, $subjectId, $semesterId)
    {
        return DB::table('subjects_details')
            ->where(
                [
                    ['subjects_details.classroom_id', $classroomId], ['subjects_details.year_id', $yearId],
                    ['subjects_details.semester_id', $semesterId], ['subjects_details.subject_id', $subjectId]
                ])
            ->delete();
    }

    public static function detachTeacherFromClassroom($classroomId, $yearId, $teacherId, $semesterIds = null)
    {
        $query = DB::table('users_teachers_details')
            ->where(
                [
                    ['users_teachers_details.classroom_id', $classroomId], ['users_teachers_details.year_id', $yearId],
                    ['users_teachers_details.user_id', $teacherId]
                ]);

        if (!is_null($semesterIds)) {
            $query->whereIn('semester_id', $semesterIds);
        }
        return $query->delete();
    }

    public static function getSubjectsWithTeacher($request)
    {
        return Subject::with([
            'teachers' => function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->whereNotIn('users.id', function ($query) use ($request) {
                        $query->select('user_id')->from('users_teachers_details')
                            ->where([
                                ['users_teachers_details.classroom_id', '=', $request['classroomId']],
                                ['users_teachers_details.year_id', $request['yearId']],
                                ['users_teachers_details.semester_id', $request['semesterId']]]);
                    })->orWhereNull('users.id');
                })->select('users.id', 'users.name');
            }
        ])->whereNotIn('subjects.id', function ($query) use ($request) {
            $query->select('subject_id')->from('subjects_details')
                ->where([['classroom_id', '=', $request['classroomId']],
                    ['year_id', $request['yearId']],
                    ['semester_id', $request['semesterId']]]);
        })->select('subjects.id', 'subjects.name')->get();
    }
}