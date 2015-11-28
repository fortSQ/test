<?php

namespace Fool\Filter;

use Fool\Card;

class RankLessFilter extends RankFilterAbstract implements FilterInterface
{
    public function apply(array $cardList)
    {
        return $this->_apply($cardList, self::LESS_THAN);
    }
}