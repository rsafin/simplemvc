<?php

namespace Simple\Routing;

use Simple\Http\Request;

class RouteCollection
{
    private $routes = [];

    public function add(Route $route)
    {
        $this->routes[$route->methods()][$route->getUri()] = $route;
        return $route;
    }

    public function match(Request $request)
    {
        $routes = $this->get($request->getMethod());

        foreach ($routes as $route)
        {
            if($route->matches($request)) {
                return $route;
            };

        }

        return $route = $routes[$request->getRequestUri()];
    }

    public function get($method)
    {
        return $this->routes[$method];
    }
}