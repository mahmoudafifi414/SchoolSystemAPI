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

    public function applyTeachersToSubject($subjectId, Request $request)
    {
        try {
            Subject::find($subjectId)->teachers()->sync($request->all());
            return response()->json(['msg' => 'Teachers Assigned Successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['msg' => 'Error Happened'], 500);
        }
    }

    public function getRelationsData($subjectId)
    {
        $yearRelationData = Subject::with([
            'teachers' => function ($query) {
                $query->select('users.id', 'users.name');
            }
        ])->select('subjects.id','subjects.name')->find($subjectId);
        return response()->json(['data' => $yearRelationData], 200);

    }
}
