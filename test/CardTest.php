<?php

namespace Fool\Test;

use Fool\Resource\TestCase;
use Fool\Card;
use Fool\Card\Suit;
use Fool\Card\Rank;

class CardTest extends TestCase
{
    public function testEqualsCard()
    {
        $card = Card::create(Suit::SPADES, Rank::ACE);
        $this->assertTrue($card->isEquals(Suit::SPADES, Rank::ACE));
        $this->assertTrue($card->isEquals($card));
    }
}
