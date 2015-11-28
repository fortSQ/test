<?php

namespace Fool;

use Fool\Condition\CardCondition;

class Player
{
    /** @var Game Игра */
    private $game;

    /** @var int Команда */
    private $command;

    /** @var Card[] Карты на руках */
    private $cardList = [];

    private function __construct(Game $game, $command)
    {
        $this->game = $game;
        $this->command = $command;
    }

    public static function create(Game $game, $command)
    {
        return new self($game, $command);
    }

    /**
     * Взять карту
     *
     * @param Card $card
     */
    public function takeCard(Card $card)
    {
        $this->cardList[] = $card;
        //$this->sortCardList();
    }

    /**
     * Получить список карт
     *
     * @param CardCondition|null $cardCondition Условие выборки
     *
     * @return Card[]
     */
    public function getCardList(CardCondition $cardCondition = null)
    {
        if ($cardCondition) {
            return $cardCondition->execute($this->cardList);
        } else {
            $this->sortCardList();
            return $this->cardList;
        }
    }

    /**
     * Вывести список карт
     *
     * @param CardCondition|null $cardCondition Условие выборки
     *
     * @return string
     */
    public function printCardList(CardCondition $cardCondition = null)
    {
        $returnList = [];
        if ($cardCondition) {
            $returnList = $cardCondition->execute($this->cardList);
        } else {
            $this->sortCardList();
            $returnList = $this->cardList;
        }
        return implode(' ', $returnList);
    }

    /**
     * Отсортировать карты
     */
    private function sortCardList()
    {
        usort($this->cardList, function(Card $cardA, Card $cardB) {
            if ($cardA->getSuit()->getOrder() == $cardB->getSuit()->getOrder()) {
                return $cardA->getRank()->getOrder() > $cardB->getRank()->getOrder();
            } else {
                return $cardA->getSuit()->getOrder() > $cardB->getSuit()->getOrder();
            }
        });
    }

    /**
     * Получить номер команды
     *
     * @return int
     */
    public function getCommand()
    {
        return $this->command;
    }
}