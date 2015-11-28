<?php

namespace Fool\Test;

use Fool\Resource\Mock;
use Fool\Resource\TestCase;
use Fool\Card;
use Fool\Card\Suit;

class FilterTest extends TestCase
{
    public function testTrump()
    {
        $roundMock = new Mock\Round([
            'getTrump' => Suit::create(Suit::SPADES)
        ]);
        $suit = Suit::create(Suit::SPADES, $roundMock);
        $this->assertTrue($suit->isTrump());
    }
}
