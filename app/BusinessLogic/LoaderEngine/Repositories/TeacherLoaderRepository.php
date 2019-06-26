<?php

namespace App\BusinessLogic\LoaderEngine\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TeacherLoaderRepository implements Repository
{
    public function getEntityData(?array $condition)
    {
        $columns = ['Id', 'Name', 'Email', 'Semester', 'Action'];
        $teacherData = DB::table('users')
            ->rightJoin('users_teachers_details', 'users.id', '=', 'users_teachers_details.user_id')
            ->rightJoin('semesters', 'users_teachers_details.semester_id', '=', 'semesters.id');
        if (is_array($condition)) {
            $teacherData->where($condition);
        }
        $teacherData->select(
            ['users.id AS Id',
                'users.name AS Name',
                'users.email AS Email',
                DB::raw("GROUP_CONCAT(semesters.name) AS Semester")
            ]
        );
        $teacherData->groupBy('users_teachers_details.user_id');
        $response['tableData'] = $teacherData->get();
        $response['tableColumns'] = $columns;
        return $response;
    }
}