<?php

use Fool\Condition;

abstract class CardConditionAbstract
{
    protected $params;

    public function __construct(CardCondition $cardCondition)
    {
        $this->params = &$cardCondition->getAll();
    }
}