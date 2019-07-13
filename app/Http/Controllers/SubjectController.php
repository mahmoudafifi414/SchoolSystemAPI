<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Utilities\Repositories\SubjectRepository;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index($numberPerPage = null)
    {
        if ($numberPerPage) {
            $subjects = Subject::paginate($numberPerPage);
        } else {
            $subjects = Subject::get();
        }
        return response()->json(['subjects' => $subjects], 200);
    }

    public function create(Request $request)
    {
        try {
            Subject::create([
                'name' => $request->name,
            ]);
            return response()->json(['msg' => 'Subject Added Successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['msg' => 'Error Occurred'], 500);
        }
    }

    public function getRelatedTeachers($subjectId)
    {
        try {
            $relatedTeachers = SubjectRepository::getRelatedTeachers($subjectId);
            return response()->json(['relatedTeachers' => $relatedTeachers], 200);
        } catch (\Exception $exception) {
            return response()->json(['msg' => 'Error Occurred'], 500);
        }
    }
}
