<?php

namespace Fool\Filter;

use Fool\Card;

class TrumpFilter implements FilterInterface
{
    public function apply(array $cardList)
    {
        /** @var Card $card */
        foreach ($cardList as $card) {
            if (!$card->getSuit()->isTrump()) {
                return [];
            }
        }
        return $cardList;
    }
}