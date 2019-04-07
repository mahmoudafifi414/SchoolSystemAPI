<?php

namespace App\Http\Controllers;

use App\BusinessLogic\LoaderEngine\ModelBuilder;
use App\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index($numberPerPage = null)
    {
        if ($numberPerPage) {
            $classrooms = Classroom::paginate($numberPerPage);
        } else {
            $classrooms = Classroom::get();
        }
        return response()->json(['classrooms' => $classrooms], 200);
    }

    public function getRelatedYears($classroomsId)
    {
        $relatedYears = Classroom::with(['years' => function ($query) {
            $query->select('years.id', 'years.name');
        }])->select('id')->find($classroomsId);
        return response()->json(['data' => $relatedYears], 200);
    }

    public function getDisplayOptionData(Request $request)
    {
        $classroomId = $request->classroomId;
        $yearId = $request->yearId;
        $optionName = $request->optionName;
        $prefix = in_array($optionName, array('Students', 'Teachers')) ? 'users_' : '';
        $condition = [[$prefix . lcfirst($optionName) . '_details.classroom_id', '=', $classroomId], [$prefix . lcfirst($optionName) . '_details.year_id', '=', $yearId]];
        try {
            $builder = new ModelBuilder(app()->make($optionName), $condition);
            return response()->json(['data' => $builder->build()]);
        } catch (\Exception $exception) {
            return $exception;
            $returnedArray = array('tableColumns' => array(), 'tableData' => array());
            return response()->json(['data' => $returnedArray]);
        }
    }
}
