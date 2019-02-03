<?php

namespace App\Http\Controllers;

use App\EducationalLevel;
use Illuminate\Http\Request;

class EducationalLevelController extends Controller
{
    public function index()
    {
        $educationalLevels = EducationalLevel::all();
        return response()->json(['educationalLevels' => $educationalLevels], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:10',
        ]);
        $educationalLevel = EducationalLevel::create([
            'name' => $request->get('name'),
        ]);
        return response()->json(['educationalLevel' => $educationalLevel], 200);
    }

    public function delete($educationalLevelId)
    {
        $educationalLevel = EducationalLevel::find($educationalLevelId);

        if ($educationalLevel->delete()) {
            return response()->json(['educationalLevelStatus' => 'deleted']);
        }
        return response()->json(['educationalLevelStatus' => 'notDeleted']);

    }
}
