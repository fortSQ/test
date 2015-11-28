<?php

namespace Fool;

use Fool\Card\Suit;
use Fool\Card\Rank;

class Card
{
    /** @var Suit Масть */
    private $suit;

    /** @var Rank Достоинство */
    private $rank;

    public function __construct($suit, $rank, Round $round = null)
    {
        $this->suit = Suit::create($suit, $round);
        $this->rank = Rank::create($rank);
    }

    public static function create($suit, $rank, Round $round = null)
    {
        return new self($suit, $rank, $round);
    }

    /**
     * Получить масть
     *
     * @return Suit
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * Получить достоинство
     *
     * @return Rank
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Сравнить карту с мастью и достоинством или картой
     *
     * @param string|Card   $suitOrCard
     * @param string        $rank
     *
     * @return bool
     */
    public function isEquals($suitOrCard, $rank = null)
    {
        if (is_null($rank) && $suitOrCard instanceof self) {
            $rank = $suitOrCard->getRank();
            $suitOrCard = $suitOrCard->getSuit();
        }
        return $suitOrCard == $this->suit && $rank == $this->rank;
    }

    /**
     * Вывод изображения карты
     *
     * @example ♦10
     *
     * @return string
     */
    public function __toString()
    {
        return $this->suit->getPrint() . $this->rank->getPrint();
    }
}