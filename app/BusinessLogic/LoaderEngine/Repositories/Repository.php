<?php

namespace App\BusinessLogic\LoaderEngine\Repositories;
interface Repository
{
    public function getEntityData(?array $condition);
}