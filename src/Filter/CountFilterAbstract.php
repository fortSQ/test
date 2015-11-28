<?php

namespace Fool\Filter;

use Fool\Card;
use Fool\Card\Rank;
use Fool\Card\Suit;

abstract class CountFilterAbstract
{
    const FROM  = 'from';
    const TO    = 'to';
    const MORE  = 'more';
    const LESS  = 'less';

    /** @var int Количество карт */
    private $count = 1;

    /** @var string Эквивалентность (масть/достоинство) */
    private $equalType;

    public function __construct($count, $equalType)
    {
        $this->count = $count;
        $this->equalType = $equalType;
    }

    protected function _apply(array $cardList, $type)
    {
        $cardCountListByEqualType = [];
        $arrayList = $this->equalType == Suit::class ? Suit::$arrayList : Rank::$arrayList;
        foreach ($arrayList as $item) {
            $cardCountListByEqualType[$item] = 0;
        }
        foreach ($cardList as $card) {
            $cardCountListByEqualType[$this->getEqualTypeItemNameByCard($card)]++;
        }
        $filterCardList = [];
        foreach($cardList as $card) {
            if($this->checkCardCount($card, $cardCountListByEqualType, $type)) {
                $filterCardList[] = $card;
            }
        }
        return $filterCardList;
    }

    /**
     * Получить наименование масти или достоинства
     *
     * @param Card $card
     *
     * @return string
     */
    private function getEqualTypeItemNameByCard(Card $card)
    {
        $name = $this->equalType == Suit::class ? $card->getSuit() : $card->getRank();
        return (string) $name;
    }

    /**
     * Проверить выполнимость условия необходимого количества карты в списке по типу границы
     *
     * @param Card $card
     * @param Card[] $countCardList
     * @param $type
     *
     * @return bool
     */
    private function checkCardCount(Card $card, array $countCardList, $type)
    {
        $itemName = $this->getEqualTypeItemNameByCard($card);
        switch ($type) {
            case self::FROM:
                return $countCardList[$itemName] >= $this->count;
            case self::TO:
                return $countCardList[$itemName] <= $this->count;
            case self::MORE:
                return $countCardList[$itemName] > $this->count;
            case self::LESS:
                return $countCardList[$itemName] < $this->count;
        }
    }
}