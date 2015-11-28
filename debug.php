<?php

require_once 'autoload.php';

echo '<pre>';

$game = \Fool\Game::create();
$round = $game->newRound();

echo 'Колода на столе: ' . $round->printDeck() . PHP_EOL;
echo 'Козырная масть: ' . $round->getTrump()->getPrint() . PHP_EOL;

foreach ($game->getPlayerList() as $player) {
    echo $player->getCommand() . '-я команда: ' . $player->printCardList() . PHP_EOL;
}

echo PHP_EOL;

$cardCondition = (new \Fool\Condition\CardCondition())
    ->countFrom(2, \Fool\Card\Rank::class)
    ->isNotTrump()
    ->rankLess(\Fool\Card\Rank::NINE);
$playerFirst = array_shift($game->getPlayerList());
echo 'Карты для первого хода: ' . $player->printCardList($cardCondition) . PHP_EOL;

echo '</pre>';

function fun(array $array, $k) {
    $n = count($array);
    $indexArray = [];
    // инициация массива индексов начальными значениями
    for ($i = 0; $i < $k; $i++) {
        $indexArray[$i] = $i;
    }
    // замыкание для перевода массива индексов в массив значений
    $indexToItem = function($indexArray) use ($array) {
        $returnArray = [];
        foreach ($indexArray as $index) {
            $returnArray[] = $array[$index];
        }
        return $returnArray;
    };
    // заносим начальную выборку
    $resultArray = [$indexToItem($indexArray)];
    while (true) {
        $currentPosition = $k - 1; # последний элемент
        // пока возможно - увеличиваем последний индекс и добавляем в выборку
        while ($indexArray[$currentPosition] < $n - $k + $currentPosition) {
            $indexArray[$currentPosition]++;
            $resultArray[] = $indexToItem($indexArray);
        }
        // как только последний увеличить нельзя - двигаемся по направлению к первому элементу
        // до момента, когда текущий индекс еще можно увеличить
        while($indexArray[$currentPosition] >= $n - $k + $currentPosition) {
            $currentPosition--;
            // выход из цикла
            if ($currentPosition < 0) {
                return $resultArray;
            }
        }
        // увеличиваем индекс в этой позиции
        $startNumber = ++$indexArray[$currentPosition];
        // и по направлению к последнему элементу
        // поочередно увеличиваем значение на единицу от предыдущего значения
        for ($i = $currentPosition + 1; $i < $k; $i++) {
            $indexArray[$i] = ++$startNumber;
        }
        $resultArray[] = $indexToItem($indexArray); # добавляем, и вновь цикл с последнего элемента
    }
}
echo '!!!';
$r = fun(['a', 'b', 'c', 'd'], 2);
echo '<pre>';
print_r($r);
echo '</pre>';
die();