<?php

namespace Fool\Filter;

use Fool\Card;

class RankMoreFilter extends RankFilterAbstract implements FilterInterface
{
    public function apply(array $cardList)
    {
        return $this->_apply($cardList, self::GREATER_THAN);
    }
}