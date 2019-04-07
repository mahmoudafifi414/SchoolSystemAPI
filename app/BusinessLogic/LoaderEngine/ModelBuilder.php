<?php

namespace App\BusinessLogic\LoaderEngine;

use App\BusinessLogic\LoaderEngine\Strategies\StrategyInterface;

class ModelBuilder
{
    private $strategy;
    private $condition;

    public function __construct(StrategyInterface $strategy, ?array $condition)
    {
        $this->strategy = $strategy;
        $this->condition = $condition;
    }

    public function build()
    {
        return $this->strategy->build($this->condition);
    }
}