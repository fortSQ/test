<?php

namespace Fool\Filter;

use Fool\Card;

class RankToFilter extends RankFilterAbstract implements FilterInterface
{
    public function apply(array $cardList)
    {
        return $this->_apply($cardList, self::LESS_THAN_OR_EQUAL_TO);
    }
}