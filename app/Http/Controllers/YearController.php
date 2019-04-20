<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Semester;
use App\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        try {
            $year = Year::create([
                'name' => $request->name,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate
            ]);
            return response()->json(['msg' => 'Year Added Successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['msg' => 'Error Occurred'], 500);
        }

    }

    public function getRelationsData($yearId)
    {
        $yearRelationData = Year::with([
            'classrooms' => function ($query) {
                $query->select('classrooms.id', 'classrooms.name');
            },
            'students' => function ($query) {
                $query->select('users.id', 'users.name');
            },
            'semesters' => function ($query) {

            }
        ])->find($yearId);
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

    public function attachSemester(Request $request)
    {
        $yearId = $request->yearId;
        $semesterId = $request->semesterId;
        try {
            $year = Year::find($yearId);
            if (!$year->semesters->contains($semesterId)) {
                $year->semesters()->attach([
                    $semesterId => [
                        'start_date' => $request->startDate,
                        'end_date' => $request->endDate
                    ]
                ]);
            }
            $returnData = Semester::find($semesterId);
            $returnData['pivot'] = DB::table('year_semester')->where([
                ['semester_id', $semesterId],
                ['year_id', $yearId]
            ])
                ->first(['year_id', 'semester_id', 'start_date', 'end_date']);
            return response()->json(['data' => $returnData], 200);
        } catch (\Exception $exception) {
            return response()->json(['data' => 'failed to attach semester to year'], 500);
        }
    }

    public function detachSemester(Request $request)
    {
        $yearId = $request->yearId;
        $semesterId = $request->semesterId;
        try {
            $year = Year::find($yearId);
            $returnData = $semesterId;
            $year->semesters()->detach($semesterId);
            return response()->json(['data' => $returnData], 200);
        } catch (\Exception $exception) {
            return response()->json(['data' => 'failed to detach semester from year'], 500);
        }
    }
}
