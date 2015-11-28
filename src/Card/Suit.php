<?php

namespace Fool\Card;

use Exception;
use Fool\IRound;

/**
 * Class Suit Масть
 *
 * @package Fool\Card
 */
class Suit
{
    const SPADES    = 'spades';     # крести
    const CLUBS     = 'clubs';      # пики
    const DIAMONDS  = 'diamonds';   # буби
    const HEARTS    = 'hearts';     # черви

    public static $arrayList = [
        self::SPADES,
        self::CLUBS,
        self::DIAMONDS,
        self::HEARTS
    ];

    /** @var array Масти по старшинству */
    private $order = [
        self::SPADES    => 1,
        self::CLUBS     => 2,
        self::DIAMONDS  => 3,
        self::HEARTS    => 4
    ];

    /** Старшинство козырной масти */
    const TRUMP_ORDER = 5;

    /** @var array Изображения мастей */
    private $print = [
        self::SPADES    => '♣',
        self::CLUBS     => '♠',
        self::DIAMONDS  => '♦',
        self::HEARTS    => '♥'
    ];

    /** @var string Масть */
    private $suit;

    /** @var IRound Контекст кона */
    private $round;

    /**
     * Конструктор
     *
     * @param string        $suit   Масть
     * @param IRound|null   $round  Кон
     *
     * @throws Exception Несуществующая масть
     */
    private function __construct($suit, IRound $round = null)
    {
        if (!in_array($suit, self::$arrayList)) {
            throw new Exception('Wrong suit');
        }
        $this->suit = $suit;
        $this->round = $round;
    }

    /**
     * Создание масти
     *
     * @param string        $suit   Масть
     * @param IRound|null   $round  Раунд
     *
     * @return Suit
     */
    public static function create($suit, IRound $round = null)
    {
        return new self($suit, $round);
    }

    /**
     * Получить порядок старшинства
     *
     * @return int
     */
    public function getOrder()
    {
        if ($this->round && $this->suit == $this->round->getTrump()) {
            return self::TRUMP_ORDER;
        }
        return isset($this->order[$this->suit]) ? $this->order[$this->suit] : 0;
    }

    /**
     * Получить графическое отображение
     *
     * @return string
     */
    public function getPrint()
    {
        return isset($this->print[$this->suit]) ? $this->print[$this->suit] : '';
    }

    /**
     * Козырь?
     *
     * @return bool
     */
    public function isTrump()
    {
        return $this->suit == $this->round->getTrump();
    }

    public function __toString()
    {
        return $this->suit;
    }
}
