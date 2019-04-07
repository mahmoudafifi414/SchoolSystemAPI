<?php

namespace App\BusinessLogic\LoaderEngine\Strategies;

use App\BusinessLogic\LoaderEngine\Repositories\TeacherLoaderRepository;

class TeacherStrategy implements StrategyInterface
{

    private $teacherLoaderRepository;

    public function __construct(TeacherLoaderRepository $teacherLoaderRepository)
    {
        $this->teacherLoaderRepository = $teacherLoaderRepository;
    }

    public function build(?array $condition)
    {
        return $this->getColumnsAndData($condition);
    }

    public function getColumnsAndData(?array $condition)
    {
        return $this->teacherLoaderRepository->getEntityData($condition);
    }
}