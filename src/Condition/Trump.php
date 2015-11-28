<?php

namespace Fool\Condition;

use Fool\Filter\NotTrumpFilter;
use Fool\Filter\TrumpFilter;

class Trump extends \CardConditionAbstract
{
    public function add($isTrump)
    {
        //$params[CardCondition::TRUMP] = (bool) $isTrump;
    }

    public function execute(array $cardList)
    {
        $filterClass = $this->params[CardCondition::TRUMP] ? new TrumpFilter() : new NotTrumpFilter();
        return $filterClass->apply($cardList);
    }
}