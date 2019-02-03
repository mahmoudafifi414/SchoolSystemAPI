<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return response()->json(['subjects' => $subjects], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:10',
        ]);
        $subject = Subject::create([
            'name' => $request->get('name'),
        ]);
        return response()->json(['subject' => $subject], 200);
    }

    public function delete($subjectId)
    {
        $subject = EducationalLevel::find($subjectId);

        if ($subject->delete()) {
            return response()->json(['subjectStatus' => 'deleted']);
        }
        return response()->json(['subjectStatus' => 'notDeleted']);

    }
}
