<?php

namespace Fool\Filter;

require_once 'Interface.php';

class CountFromFilter extends CountFilterAbstract implements FilterInterface
{
    public function apply(array $cardList)
    {
        return $this->_apply($cardList, self::FROM);
    }
}