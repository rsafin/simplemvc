<?php

namespace Simple\Routing;

use BadMethodCallException;

abstract class Controller
{
    public function callAction($method, $parameters)
    {
        return call_user_func([$this, $method], $parameters);
    }

    public function __call($name, $arguments)
    {
        throw new BadMethodCallException("Method [{$name}] does not exist on [".get_class($this).'].');
    }
}