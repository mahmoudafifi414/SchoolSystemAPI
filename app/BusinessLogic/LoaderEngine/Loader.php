<?php

abstract class Loader
{
    protected $modelName;

    protected function __construct($modelName)
    {
        $this->modelName = $modelName;
    }

    protected abstract function loadModel();

}