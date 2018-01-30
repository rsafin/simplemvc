<?php

namespace Simple\Routing;

use Simple\Http\Request;

class Route
{
    private $uri;
    private $method;
    private $action;
    private $controller;
    private $regexp;
    private $parameters;

    /*;
    private $parameterNames;*/

    public function __construct($method, $uri, $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;

        $this->compileRegexp();


        //TODO: вынести и реализовать передачу пораметров в конструтор контролера
        list($this->controller, $this->action) = explode('@', $action);

        $controllerName = "\Controllers\\" . ucfirst($this->controller);

        $this->controller = new $controllerName();
    }

    private function compileRegexp()
    {
        $pattern = '/{[a-zA-Z0-9]+}/';
        $regexp = preg_replace($pattern,'([a-zA-Z0-9]+)', $this->getUri());
        $regexp = str_replace('/', '\/', $regexp);
        $this->regexp = '/^' . $regexp . '$/';
    }

    public function run()
    {
        return $this->runController();
    }

    private function runController()
    {
        return $this->controllerDispatcher()->dispatch($this->controller, $this->action, $this->parameters);
    }


    public function controllerDispatcher()
    {
        return new ControllerDispatcher();
    }


    public function matches(Request $request)
    {
        $matches = preg_match($this->regexp, $request->getRequestUri());
        return $matches;
    }

    public function bind(Request $request)
    {
        $matchParams = [];
        preg_match($this->regexp, $request->getRequestUri(), $matchParams);
        unset($matchParams[0]);
        $this->parameters = $matchParams;
    }

    public function getRegexp()
    {
        return $this->regexp;
    }


    public function methods()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }
}