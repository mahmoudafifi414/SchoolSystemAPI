<?php

namespace App\Http\Controllers;

use App\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index($numberPerPage = 10)
    {
        $years = Year::paginate($numberPerPage);
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
}
