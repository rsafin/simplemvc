<?php

namespace Simple\Routing;

use Simple\Http\Request;

class Router
{
    private $currentRequest;
    private $routes;

    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    public function dispatch(Request $request)
    {
        $this->currentRequest = $request;

        return $this->dispatchToRoute($request);
    }

    public function dispatchToRoute (Request $request)
    {
        return $this->runRoute($this->findRoute($request));
    }

    private function runRoute($route)
    {
        return $route->run();
    }

    private function findRoute(Request $request)
    {
        $route = $this->routes->match($request);

        return $route;
    }

    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    private function addRoute($method, $uri, $action)
    {
        $this->routes->add($this->createRoute($method, $uri, $action));
    }

    private function createRoute($method, $uri, $action)
    {
        return new Route($method, $uri,$action);
    }
}