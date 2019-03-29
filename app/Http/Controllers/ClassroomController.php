<?php

namespace App\Http\Controllers;

use App\Classroom;

class ClassroomController extends Controller
{
    public function index($numberPerPage = null)
    {
        if ($numberPerPage) {
            $classrooms = Classroom::paginate($numberPerPage);
        } else {
            $classrooms = Classroom::get();
        }
        return response()->json(['classrooms' => $classrooms], 200);
    }

    public function getRelatedYears($classroomsId)
    {
        $relatedYears = Classroom::with(['years' => function ($query) {
            $query->select('years.id', 'years.name');
        }])->select('id')->find($classroomsId);
        return response()->json(['data' => $relatedYears], 200);
    }

    public function getDisplayOptionData($entityId)
    {

    }
    /*$classrooms = DB::table('classrooms')
            ->join('classroom_year', 'classrooms.id', '=', 'classroom_year.classroom_id')
            ->join('years', 'classroom_year.year_id', '=', 'years.id')
            ->select('classrooms.id as classroomId','classrooms.name AS classroomName','years.name AS yearName')
            ->paginate(10);
        return response()->json(['classrooms' => $classrooms], 200);
    }*/
}
