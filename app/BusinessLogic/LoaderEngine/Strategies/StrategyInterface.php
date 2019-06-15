<?php

namespace App\BusinessLogic\LoaderEngine\Strategies;
interface StrategyInterface
{
    public function build(?array $condition);
}