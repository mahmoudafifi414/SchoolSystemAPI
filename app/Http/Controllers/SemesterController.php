<?php

namespace App\Http\Controllers;

use App\Semester;
use App\Subject;
use App\SubjectDetails;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index($numberPerPage = null)
    {
        if ($numberPerPage) {
            $semesters = Semester::paginate($numberPerPage);
        } else {
            $semesters = Semester::get();
        }
        return response()->json(['semesters' => $semesters], 200);
    }

    public function create(Request $request)
    {
        try {
            $semester = Semester::create([
                'name' => $request->name,
            ]);
            return response()->json(['msg' => 'semester Added Successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['msg' => 'Error Occurred'], 500);
        }

    }
}
