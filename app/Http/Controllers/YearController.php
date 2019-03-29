<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index($numberPerPage = null)
    {
        if ($numberPerPage) {
            $years = Year::paginate($numberPerPage);
        } else {
            $years = Year::get();
        }
        return response()->json(['years' => $years], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required'
        ]);
        $startDateTime = Carbon::parse($request->startDate);
        $endDateTime = Carbon::parse($request->endDate);
        $year = Year::create([
            'name' => $request->name,
            'start_date' => $startDateTime->format('Y-m-d'),
            'end_date' => $endDateTime->format('Y-m-d')
        ]);
        return response()->json(['year' => $year], 200);
    }

    public function getRelationsData($yearId)
    {
        $yearRelationData = Year::with(['classrooms' => function ($query) {
            $query->select('classrooms.id', 'classrooms.name');
        }, 'students' => function ($query) {
            $query->select('users.id', 'users.name');
        }])->find($yearId);
        return response()->json(['data' => $yearRelationData], 200);
    }

    public function attachClassroom(Request $request)
    {
        $yearId = $request->yearId;
        $classroomId = $request->classroomId;
        try {
            $year = Year::find($yearId);
            if ($classroomId == 'attach_all_classrooms') {
                $classroomIds = Classroom::pluck('id')->toArray();
                $year->classrooms()->sync($classroomIds);
                $returnData = Classroom::get();
            } else {
                if (!$year->classrooms->contains($classroomId)) {
                    $year->classrooms()->attach($classroomId);
                }
                $returnData = Classroom::find($classroomId);
            }
            return response()->json(['data' => $returnData], 200);
        } catch (\Exception $exception) {
            return response()->json(['data' => 'failed to attach classroom to year'], 500);
        }
    }

    public function detachClassroom(Request $request)
    {
        $yearId = $request->yearId;
        $classroomId = $request->classroomId;
        try {
            $year = Year::find($yearId);
            if ($classroomId == 'detach_all_classrooms') {
                $classroomId = Classroom::pluck('id')->toArray();
                $returnData = $classroomId;
            } else {
                $returnData = $classroomId;
            }
            $year->classrooms()->detach($classroomId);
            return response()->json(['data' => $returnData], 200);
        } catch (\Exception $exception) {
            return response()->json(['data' => 'failed to detach classroom from year'], 500);
        }
    }
}
