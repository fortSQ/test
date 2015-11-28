<?php

namespace Fool\Filter;

use Fool\Card;

interface FilterInterface
{
    /**
     * Применить фильтр для списка карт
     *
     * @param Card[] $cardList
     *
     * @return Card[]
     */
    public function apply(array $cardList);
}