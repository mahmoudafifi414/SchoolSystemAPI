<?php

namespace App\BusinessLogic\LoaderEngine\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class StudentLoaderRepository implements Repository
{
    public function getEntityData(?array $condition)
    {
        $columns=['Id','Name','Email','Address'];
        $studentData = DB::table('users')
            ->rightJoin('users_students_details', 'users.id', '=', 'users_students_details.user_id')
            ->select('users.id AS Id',
                'users.name AS Name',
                'users.email AS Email',
                DB::raw("CONCAT(users.country,'-',users.city) AS Address")
            );
        if (is_array($condition)) {
            $studentData->where($condition);
        }
        $response['tableData']=$studentData->get();
        $response['tableColumns']=$columns;
        return $response;
    }
}