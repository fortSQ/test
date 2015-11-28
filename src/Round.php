<?php

namespace Fool;

use Fool\Card\Rank;
use Fool\Card\Suit;

class Round implements IRound
{
    const INIT_CARD_COUNT = 6; # по сколько карт раздаем в начале

    /** @var Game Игра */
    private $game;

    /** @var Card[] $deck Колода */
    private $deck = [];

    /** @var Suit Козырь */
    private $trump;

    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->initDeck();
        $this->dealCards();
    }

    /**
     * Определяем колоду из 36 карт и тасуем ее
     */
    private function initDeck()
    {
        foreach (Suit::$arrayList as $suit) {
            foreach (Rank::$arrayList as $rank) {
                $this->deck[] = Card::create($suit, $rank, $this);
            }
        }
        shuffle($this->deck);
        // TODO: debug
        echo 'Исходная тасованая колода: ' . $this->printDeck() . PHP_EOL;
    }

    /**
     * Раздача карт
     */
    public function dealCards()
    {
        $playerList = $this->game->getPlayerList();
        for ($i = 0; $i < self::INIT_CARD_COUNT; $i++)
        {
            foreach ($playerList as $player) {
                $currentCard = array_shift($this->deck);
                $player->takeCard($currentCard);
            }
        }
        // вытаскиваем козырь, ложим на стол, и он будет последней картой в колоде
        /** @var Card $trumpCard */
        $trumpCard = array_shift($this->deck);
        $this->trump = $trumpCard->getSuit();
        $this->deck[] = $trumpCard;
    }

    /**
     * Получить козырную масть
     *
     * @return Suit
     */
    public function getTrump()
    {
        return $this->trump;
    }

    /**
     * Получить список карт в колоде
     *
     * @return Card[]
     */
    public function getDeck()
    {
        return $this->deck;
    }

    /**
     * Вывести список карт в колоде
     *
     * @return string
     */
    public function printDeck()
    {
        return implode(' ', $this->deck);
    }
}
