<?php

namespace Fool\Condition;

use Fool\Card;
use Fool\Card\Rank;
use Fool\Filter\CountFromFilter;
use Fool\Filter\CountLessFilter;
use Fool\Filter\CountMoreFilter;
use Fool\Filter\CountToFilter;
use Fool\Filter\FilterInterface;
use Fool\Filter\NotTrumpFilter;
use Fool\Filter\RankFromFilter;
use Fool\Filter\RankLessFilter;
use Fool\Filter\RankMoreFilter;
use Fool\Filter\RankToFilter;
use Fool\Filter\TrumpFilter;
use Exception;

class CardCondition
{
    const COUNT = 'count';
    const TRUMP = 'trump';
    const RANK  = 'rank';

    const FROM  = 'from';
    const TO    = 'to';
    const MORE  = 'more';
    const LESS  = 'less';

    const EQUAL_TYPE = 'equal_type';

    /** @var array Список условий */
    private $list = [];

    /**
     * Получить список условий
     *
     * @return array
     */
    public function getAll()
    {
        return $this->list;
    }

    /**
     * Количество от (включительно) равных по типу
     *
     * @param int $count
     * @param string $equalType
     *
     * @return $this
     */
    public function countFrom($count, $equalType)
    {
        $this->list[self::COUNT][self::FROM] = $this->getArrayForCount($count, $equalType);
        return $this;
    }

    /**
     * Количество до (включительно) равных по типу
     *
     * @param int $count
     * @param string $equalType
     *
     * @return $this
     */
    public function countTo($count, $equalType)
    {
        $this->list[self::COUNT][self::TO] = $this->getArrayForCount($count, $equalType);
        return $this;
    }

    /**
     * Количество менее равных по типу
     *
     * @param int $count
     * @param string $equalType
     *
     * @return $this
     */
    public function countLess($count, $equalType)
    {
        $this->list[self::COUNT][self::LESS] = $this->getArrayForCount($count, $equalType);
        return $this;
    }

    /**
     * Количество более равных по типу
     *
     * @param int $count
     * @param string $equalType
     *
     * @return $this
     */
    public function countMore($count, $equalType)
    {
        $this->list[self::COUNT][self::MORE] = $this->getArrayForCount($count, $equalType);
        return $this;
    }

    /**
     * Параметры условия для количества равных по типу
     *
     * @param int $count
     * @param string $equalType
     *
     * @return array
     */
    private function getArrayForCount($count, $equalType)
    {
        return [
            self::COUNT         => $count,
            self::EQUAL_TYPE    => $equalType
        ];
    }

    /**
     * Козырь
     *
     * @return $this
     */
    public function isTrump()
    {
        $this->trump(true);
        return $this;
    }

    /**
     * Не козырь
     *
     * @return $this
     */
    public function isNotTrump()
    {
        $this->trump(false);
        return $this;
    }

    /**
     * Козырь
     *
     * @param bool $isTrump
     *
     * @return $this
     */
    public function trump($isTrump)
    {
        $this->list[self::TRUMP] = (bool) $isTrump;
        return $this;
    }

    /**
     * Достоинство от (включительно)
     *
     * @param string $rank
     *
     * @return $this
     *
     * @throws Exception Несуществующее достоинство
     */
    public function rankFrom($rank)
    {
        $rank = $this->getRank($rank);
        $this->list[self::RANK][self::FROM] = $rank;
        return $this;
    }

    /**
     * Достоинство до (включительно)
     *
     * @param string $rank
     *
     * @return $this
     *
     * @throws Exception Несуществующее достоинство
     */
    public function rankTo($rank)
    {
        $rank = $this->getRank($rank);
        $this->list[self::RANK][self::TO] = $rank;
        return $this;
    }

    /**
     * Достоинство менее
     *
     * @param string $rank
     *
     * @return $this
     *
     * @throws Exception Несуществующее достоинство
     */
    public function rankLess($rank)
    {
        $rank = $this->getRank($rank);
        $this->list[self::RANK][self::LESS] = $rank;
        return $this;
    }

    /**
     * Достоинство более
     *
     * @param string $rank
     *
     * @return $this
     *
     * @throws Exception Несуществующее достоинство
     */
    public function rankMore($rank)
    {
        $rank = $this->getRank($rank);
        $this->list[self::RANK][self::MORE] = $rank;
        return $this;
    }

    /**
     * Получить достоинство
     *
     * @param string $rank
     *
     * @return string
     *
     * @throws Exception Несуществующее достоинство
     */
    private function getRank($rank)
    {
        if (!in_array($rank, Rank::$arrayList)) {
            throw new Exception('Wrong rank');
        }
        return $rank;
    }

    ####################################################################################################################

    /**
     * Выполнить условия для списка карт
     *
     * @param Card[] $cardList
     *
     * @return Card[]
     */
    public function execute(array $cardList)
    {
        $returnCardList = $cardList;
        foreach ($this->list as $name => $params) {
            switch ($name) {
                case self::COUNT:
                    $returnCardList = $this->executeCount($returnCardList, $params);
                    break;
                case self::TRUMP:
                    $filterClass = $params ? new TrumpFilter() : new NotTrumpFilter();
                    $returnCardList = $filterClass->apply($returnCardList);
                    break;
                case self::RANK:
                    $returnCardList = $this->executeRank($returnCardList, $params);
                    break;
            }
        }
        return $returnCardList;
    }

    private function executeCount(array $returnCardList, array $params)
    {
        $filterClassName = '';
        foreach ($params as $type => $value) {
            switch ($type) {
                case self::FROM:
                    $filterClassName = CountFromFilter::class;
                    break;
                case self::TO:
                    $filterClassName = CountToFilter::class;
                    break;
                case self::LESS:
                    $filterClassName = CountLessFilter::class;
                    break;
                case self::MORE:
                    $filterClassName = CountMoreFilter::class;
                    break;
            }
            /** @var FilterInterface $filterClass */
            $filterClass = new $filterClassName($value[self::COUNT], $value[self::EQUAL_TYPE]);
            $returnCardList = $filterClass->apply($returnCardList);
            
//            echo '<pre>';
//            print_r(count($returnCardList));
//            echo '</pre>';
//            die();
        }
        return $returnCardList;
    }

    private function executeRank(array $returnCardList, array $params)
    {
        $filterClassName = '';
        foreach ($params as $type => $rank) {
            switch ($type) {
                case self::FROM:
                    $filterClassName = RankFromFilter::class;
                    break;
                case self::TO:
                    $filterClassName = RankToFilter::class;
                    break;
                case self::LESS:
                    $filterClassName = RankLessFilter::class;
                    break;
                case self::MORE:
                    $filterClassName = RankMoreFilter::class;
                    break;
            }
            /** @var FilterInterface $filterClass */
            $filterClass = new $filterClassName($rank);
            $returnCardList = $filterClass->apply($returnCardList);
        }
        return $returnCardList;
    }
}