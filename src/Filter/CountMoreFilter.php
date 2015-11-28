<?php

namespace Fool\Filter;

class CountMoreFilter extends CountFilterAbstract implements FilterInterface
{
    public function apply(array $cardList)
    {
        return $this->_apply($cardList, self::MORE);
    }
}