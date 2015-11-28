<?php

namespace Fool\Card;

use Exception;

/**
 * Class Rank Достоинство
 *
 * @package Fool\Card
 */
class Rank
{
    const SIX   = 'six';    # шесть
    const SEVEN = 'seven';  # семь
    const EIGHT = 'eight';  # восемь
    const NINE  = 'nine';   # девять
    const TEN   = 'ten';    # десять
    const JACK  = 'jack';   # валет
    const QUEEN = 'queen';  # дама
    const KING  = 'king';   # король
    const ACE   = 'ace';    # туз

    public static $arrayList = [
        self::SIX,
        self::SEVEN,
        self::EIGHT,
        self::NINE,
        self::TEN,
        self::JACK,
        self::QUEEN,
        self::KING,
        self::ACE
    ];

    /** @var array Достоинства по старшинству */
    private $order = [
        self::SIX   => 1,
        self::SEVEN => 2,
        self::EIGHT => 3,
        self::NINE  => 4,
        self::TEN   => 5,
        self::JACK  => 6,
        self::QUEEN => 7,
        self::KING  => 8,
        self::ACE   => 9
    ];

    /** @var array Изображения достоинств */
    private $print = [
        self::SIX   => '6',
        self::SEVEN => '7',
        self::EIGHT => '8',
        self::NINE  => '9',
        self::TEN   => '10',
        self::JACK  => 'J',
        self::QUEEN => 'Q',
        self::KING  => 'K',
        self::ACE   => 'A'
    ];

    /** @var string Достоинство */
    private $rank;

    /**
     * Конструктор
     *
     * @param string $rank Достоинство
     *
     * @throws Exception Несуществующее достоинство
     */
    private function __construct($rank)
    {
        if (!in_array($rank, self::$arrayList)) {
            throw new Exception('Wrong rank');
        }
        $this->rank = $rank;
    }

    /**
     * Создание достоинства
     *
     * @param string $rank Достоинство
     *
     * @return Rank
     */
    public static function create($rank)
    {
        return new self($rank);
    }

    /**
     * Получить порядок старшинства
     *
     * @return int
     */
    public function getOrder()
    {
        return isset($this->order[$this->rank]) ? $this->order[$this->rank] : 0;
    }

    /**
     * Получить графическое отображение
     *
     * @return string
     */
    public function getPrint()
    {
        return isset($this->print[$this->rank]) ? $this->print[$this->rank] : '';
    }

    public function __toString()
    {
        return $this->rank;
    }
}