<?php

namespace App\Http\Controllers;

use App\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required'
        ]);
        $startDateTime = Carbon::parse($request->startDate);
        $endDateTime = Carbon::parse($request->endDate);
        $semester = Semester::create([
            'name' => $request->name,
            'start_date' => $startDateTime->format('Y-m-d'),
            'end_date' => $endDateTime->format('Y-m-d')
        ]);
        return response()->json(['semester' => $semester], 200);
    }
}
