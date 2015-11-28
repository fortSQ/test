<?php

namespace Fool\Test;

use Fool\Resource\TestCase;

class ExampleTest extends TestCase
{
    public function testA()
    {
        //$this->assertTrue(0);
    }

    public function testB()
    {
        //$this->assertTrue(false);
    }

    public function testC()
    {
        $this->assertEquals([1, 2, 3], [3, 2, 1]);
    }
}
