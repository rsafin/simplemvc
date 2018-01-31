<?php

use Simple\Routing\Router;

class Application
{
    private static $container = [];

    public function bootstrap()
    {
        //TODO: todo
    }

    public static function store($alias, $instance)
    {
        static::$container[$alias] = $instance;
    }

    public static function get($alias)
    {
        return static::$container[$alias];
    }
}