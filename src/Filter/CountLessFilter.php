<?php

namespace Fool\Filter;

class CountLessFilter extends CountFilterAbstract implements FilterInterface
{
    public function apply(array $cardList)
    {
        return $this->_apply($cardList, self::LESS);
    }
}