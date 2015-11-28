<?php

namespace Fool\Filter;

use Fool\Card;
use Fool\Card\Rank;

abstract class RankFilterAbstract
{
    const LESS_THAN                 = '<';
    const LESS_THAN_OR_EQUAL_TO     = '<=';
    const GREATER_THAN_OR_EQUAL_TO  = '>=';
    const GREATER_THAN              = '>';

    /** @var Rank Достоинство */
    private $rank;

    public function __construct($rank)
    {
        $this->rank = Rank::create($rank);
    }

    protected function _apply(array $cardList, $relationType)
    {
        foreach ($cardList as $card) {
            if (!$this->checkCardRank($card, $relationType)) {
                return [];
            }
        }
        return $cardList;
    }

    /**
     * Проверить выполнимость условия сравнения по типу отношения
     *
     * @param Card $card
     * @param string $relationType
     *
     * @return bool
     */
    private function checkCardRank(Card $card, $relationType)
    {
        switch ($relationType) {
            case self::LESS_THAN:
                return $card->getRank()->getOrder() < $this->rank->getOrder();
            case self::LESS_THAN_OR_EQUAL_TO:
                return $card->getRank()->getOrder() <= $this->rank->getOrder();
            case self::GREATER_THAN_OR_EQUAL_TO:
                return $card->getRank()->getOrder() >= $this->rank->getOrder();
            case self::GREATER_THAN:
                return $card->getRank()->getOrder() > $this->rank->getOrder();
        }
    }
}