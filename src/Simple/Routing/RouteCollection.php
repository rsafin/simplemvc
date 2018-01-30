<?php

namespace Simple\Routing;

use Simple\Http\Request;

class RouteCollection
{
    private $routes = [];

    public function add(Route $route)
    {
        $this->routes[$route->methods()][$route->uri()] = $route;
        return $route;
    }

    public function match(Request $request)
    {
        //TODO: переработать функцию поиска нужного роута
        $routes = $this->get($request->getMethod());
        return $route = $routes[$request->getRequestUri()];

        //TODO: throw Exception route not found
    }

    public function get($method)
    {
        return $this->routes[$method];
    }
}