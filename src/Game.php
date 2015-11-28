<?php

namespace Fool;

class Game
{
    const PLAYER_COUNT  = 4; # кол-во игроков
    const COMMAND_COUNT = 2; # кол-во команд

    /** @var int Текущий номер кона */
    private $roundNumber = 0;

    /** @var Round Текущий кон */
    private $currentRound;

    /** @var Player[] Список игроков */
    private $playerList = [];

    private function __construct()
    {
        // Создаем игроков и распределяем по командам
        $currentCommand = 1;
        for ($i = 0; $i < self::PLAYER_COUNT; $i++) {
            $this->playerList[] = Player::create($this, $currentCommand);
            $currentCommand = $currentCommand < self::COMMAND_COUNT ? ++$currentCommand : 1;
        }
    }

    public static function create()
    {
        return new self();
    }

    /**
     * Играть кон
     *
     * @return Round
     */
    public function newRound()
    {
        $this->roundNumber++;
        $this->currentRound = new Round($this);
        return $this->currentRound;
    }

    /**
     * Получить игроков
     *
     * @return Player[]
     */
    public function getPlayerList()
    {
        return $this->playerList;
    }
}