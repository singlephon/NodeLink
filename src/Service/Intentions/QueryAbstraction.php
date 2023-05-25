<?php

namespace Singlephon\Nodelink\Service\Intentions;

abstract class QueryAbstraction
{
    public string $route;

    public function __construct()
    {
        $class = get_class($this);
        if (!isset($this->route))
            dd("Class [$class] does not contain route property");
    }
}
