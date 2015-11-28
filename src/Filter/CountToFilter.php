<?php

namespace Fool\Filter;

class CountToFilter extends CountFilterAbstract implements FilterInterface
{
    public function apply(array $cardList)
    {
        return $this->_apply($cardList, self::TO);
    }
}