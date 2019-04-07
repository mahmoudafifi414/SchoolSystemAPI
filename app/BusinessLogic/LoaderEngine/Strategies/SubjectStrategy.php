<?php

namespace App\BusinessLogic\LoaderEngine\Strategies;

use App\BusinessLogic\LoaderEngine\Repositories\SubjectLoaderRepository;

class SubjectStrategy implements StrategyInterface
{

    private $subjectLoaderRepository;

    public function __construct(SubjectLoaderRepository $subjectLoaderRepository)
    {
        $this->subjectLoaderRepository = $subjectLoaderRepository;
    }

    public function build(?array $condition)
    {
        return $this->getColumnsAndData($condition);
    }

    public function getColumnsAndData(?array $condition)
    {
        return $this->subjectLoaderRepository->getEntityData($condition);
    }
}