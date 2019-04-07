<?php

namespace App\BusinessLogic\LoaderEngine\Strategies;

use App\BusinessLogic\LoaderEngine\Repositories\StudentLoaderRepository;

class StudentStrategy implements StrategyInterface
{

    private $studentLoaderRepository;

    public function __construct(StudentLoaderRepository $studentLoaderRepository)
    {
        $this->studentLoaderRepository = $studentLoaderRepository;
    }

    public function build(?array $condition)
    {
        return $this->getColumnsAndData($condition);
    }

    public function getColumnsAndData(?array $condition)
    {
        return $this->studentLoaderRepository->getEntityData($condition);
    }
}