<?php

namespace App\BusinessLogic\LoaderEngine\Repositories;

use Illuminate\Support\Facades\DB;

class SubjectLoaderRepository implements Repository
{
    public function getEntityData(?array $condition)
    {
        $columns = ['Id', 'Name'];
        $subjectData = DB::table('subjects')
            ->rightJoin('subjects_details', 'subjects.id', '=', 'subjects_details.subject_id')
            ->select('subjects.id AS Id',
                'subjects.name AS Name'
            );
        if (is_array($condition)) {
            $subjectData->where($condition);
        }
        $response['tableData'] = $subjectData->get();
        $response['tableColumns'] = $columns;
        return $response;
    }
}