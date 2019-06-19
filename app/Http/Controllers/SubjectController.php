<?php

namespace App\Http\Controllers;

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
            $subject = Subject::create([
                'name' => $request->name,
            ]);
            return response()->json(['msg' => 'subject Added Successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['msg' => 'Error Occurred'], 500);
        }

    }
}
