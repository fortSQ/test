<?php

namespace Fool;

interface IRound
{
    public function dealCards();
    public function getTrump();
    public function getDeck();
    public function printDeck();
}
