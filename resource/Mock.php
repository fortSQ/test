<?php

namespace Fool\Resource;

abstract class Mock {
    private $methodList = [];

    public function __construct(array $methodList = [])
    {
        $this->methodList = $methodList;
    }

    public function __call($method, array $argumentList = [])
    {
        foreach($this->methodList as $mockMethod => $returnValue) {
            if ($mockMethod == $method) {
                return $returnValue;
            }
        }
        //return call_user_func([$this, $method], $argumentList);
        //return call_user_func($method);
        return null;
    }
}
