<?php

namespace App\Http\Controllers;

use App\BusinessLogic\LoaderEngine\ModelBuilder;
use App\BusinessLogic\Utilities\Repositories\ClassroomRepositories;
use App\BusinessLogic\Utilities\Repositories\ClassroomRepository;
use App\Classroom;
use App\Subject;
use App\SubjectDetails;
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

    public function getRelatedYears($classroomId)
    {
        $relatedYears = Classroom::with([
            'years' => function ($query) {
                $query->select('years.id', 'years.name');
            }
        ])->select('id')->find($classroomId);
        return response()->json(['data' => $relatedYears], 200);
    }

    public function getRelatedSemesters($classroomId)
    {
        $relatedSemesters = ClassroomRepository::getSemesters($classroomId);
        return response()->json(['data' => $relatedSemesters], 200);
    }

    public function getRelatedSubjects($classroomId, $yearId)
    {
        $relatedSubjects = ClassroomRepository::getSubjects($classroomId, $yearId);
        return response()->json(['data' => $relatedSubjects], 200);
    }

    public function getRelationsData($classroomId)
    {
        $classroomRelationData = Classroom::with([
            'subjects' => function ($query) {
                $query->select('subjects.id', 'subjects.name');
            }
        ])->find($classroomId);
        return response()->json(['data' => $classroomRelationData], 200);
    }

    public function getDisplayOptionData(Request $request)
    {
        $classroomId = $request->classroomId;
        $yearId = $request->yearId;
        $optionName = $request->optionName;
        $prefix = in_array($optionName, array('Students', 'Teachers')) ? 'users_' : '';
        $condition = [
            [$prefix . lcfirst($optionName) . '_details.classroom_id', '=', $classroomId],
            [$prefix . lcfirst($optionName) . '_details.year_id', '=', $yearId]
        ];
        try {
            $builder = new ModelBuilder(app()->make($optionName), $condition);
            return response()->json(['data' => $builder->build()]);
        } catch (\Exception $exception) {
            return $exception;
            $returnedArray = array('tableColumns' => array(), 'tableData' => array());
            return response()->json(['data' => $returnedArray]);
        }
    }

    public function attachSubjectToSemester(Request $request)
    {
        $yearId = $request->yearId;
        $classroomId = $request->classroomId;
        $semesterId = $request->semesterId;
        $subjectIds = $request->subjectIds;
        try {
            $data = array();
            foreach ($subjectIds as $subjectId) {
                $data[] = array('year_id' => $yearId, 'classroom_id' => $classroomId, 'semester_id' => $semesterId, 'subject_id' => $subjectId);
            }
            SubjectDetails::insert($data);
            $subjects = ClassroomRepository::getSubjectsAfterSync($classroomId, $yearId, $subjectIds, $semesterId);
            return response()->json(['data' => $subjects], 200);
        } catch (\Exception $exception) {
            return response()->json(['data' => 'failed to attach subject to semester', 'ex' => $exception], 500);
        }
    }

    public function detachSubjectToSemester(Request $request)
    {
        $yearId = $request->yearId;
        $classroomId = $request->classroomId;
        $semesterId = $request->semesterId;
        $subjectId = $request->subjectId;
        try {
            ClassroomRepository::deleteSubjectsInDetachSemester($classroomId, $yearId, $subjectId, $semesterId);
            return response()->json(['data' => array('subjectId' => $subjectId, 'semesterId' => $semesterId)], 200);
        } catch (\Exception $exception) {
            return response()->json(['data' => 'failed to detach subject from semester', 'ex' => $exception], 500);
        }
    }

    public function detachTeacherFromClassroom(Request $request)
    {
        $yearId = $request->yearId;
        $classroomId = $request->classroomId;
        $teacherId = $request->teacherId;
        try {
            ClassroomRepository::detachTeacherFromClassroom($classroomId, $yearId, $teacherId);
            return response()->json(['data' => array('teacherId' => $teacherId)], 200);
        } catch (\Exception $exception) {
            return response()->json(['data' => 'failed to detach subject from semester', 'ex' => $exception], 500);
        }

    }
}
