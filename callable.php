<?php

class Call
{
    function callFun(callable $call)
    {
        echo '+';
        $call();
    }

    function callFun2(callable $call)
    {
        echo '-';
        call_user_func($call);
    }

    function test()
    {
        echo '!';
    }
}

$c = new Call();
$c->callFun(function () use ($c) { $c->test(); });
$c->callFun2(function () use ($c) { $c->test(); });
$c->callFun2([$c, 'test']);