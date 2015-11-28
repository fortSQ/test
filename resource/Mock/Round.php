<?php

namespace Fool\Resource\Mock;

use Fool\IRound;
use Fool\Resource\Mock;

class Round extends Mock implements IRound
{
    public function dealCards() {}
    public function getTrump() { return parent::getTrump(); }
    public function getDeck() {}
    public function printDeck() {}

//    public function __call($method, array $argumentList = [])
//    {
//        echo $method;
//        die;
//        return parent::__call($method, $argumentList);
//    }
}
