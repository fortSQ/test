<?php

namespace Fool\Resource;

use Fool\Resource\Exception\TestException;

abstract class TestCase
{
    protected function assertTrue($value)
    {
        if (!$value) {
            if (is_null($value)) {
                $value = 'null';
            }
            if ($value === false) {
                $value = 'false';
            }
            throw new TestException(sprintf('%s is not true', $value));
        }
    }

    protected function assertEquals($expected, $actual)
    {
        $isEquals = false;
        if (is_scalar($expected) || is_object($expected)) {
            $isEquals = $expected == $actual;
        } elseif (is_array($expected) && is_array($actual)) {
            $isEquals = !(array_diff($expected, $actual) && array_diff($actual, $expected));
        }
        if (!$isEquals) {
            throw new TestException(sprintf('%s not equals %s', $expected, $actual));
        }
    }
}
