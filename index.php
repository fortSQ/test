<?php require_once 'autoload.php' ?>

<?
function printCard(\Fool\Card $card) {
    $class = '';
    switch ($card->getSuit()) {
        case \Fool\Card\Suit::SPADES: $class = 'primary'; break;
        case \Fool\Card\Suit::CLUBS: $class = 'default'; break;
        case \Fool\Card\Suit::DIAMONDS: $class = 'warning'; break;
        case \Fool\Card\Suit::HEARTS: $class = 'danger'; break;
    }
    return "<span class=\"label label-{$class}\" style=\"font-size:220%;margin:5px 0;display:inline-block\">{$card}</span>";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">

    <title>Fool 2x2</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <style>
        .label-danger { background-color: #f30; }
        .label-warning { background-color: #f60; }
        .label-default { background-color: #333; }
        .label-primary { background-color: #777; }
    </style>
</head>
<body>
<div class="container">
    <? $game = \Fool\Game::create() ?>
    <pre class="well lead" style="margin-top:10px; letter-spacing:.15em"><? $round = $game->newRound() ?></pre>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Колода на столе</h3>
        </div>
        <div class="panel-body">
            <? foreach ($round->getDeck() as $card) : ?>
                <?= printCard($card) ?>
            <? endforeach ?>
        </div>
    </div>
    <h3>Козырная масть: <?= $round->getTrump()->getPrint() ?></h3>
    <table class="table">
        <tbody>
        <? foreach ($game->getPlayerList() as $player) : ?>
            <tr class="text-center">
                <th style="vertical-align:middle"><?= $player->getCommand() . '-я команда'?></th>
                <? foreach ($player->getCardList() as $card) : ?>
                    <td <?= $card->getSuit() == $round->getTrump() ? 'class="success"' : '' ?>><?= printCard($card) ?></td>
                <? endforeach ?>
            </tr>
        <? endforeach ?>
        </tbody>
    </table>
</div>
</body>
</html>