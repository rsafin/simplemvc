<?php

namespace Simple\Routing;

class Route
{
    private $uri;
    private $method;
    private $action;
    private $controller;

    /*private $parameters;
    private $parameterNames;*/

    public function __construct($method, $uri, $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;


        //TODO: вынести и реализовать передачу пораметров в конструтор контролера
        list($this->controller, $this->action) = explode('@', $action);

        $controllerName = "\Controllers\\" . ucfirst($this->controller);

        $this->controller = new $controllerName();
    }

    public function run()
    {
        return $this->runController();
    }

    private function runController()
    {
        return $this->controllerDispatcher()->dispatch($this->controller, $this->action);
    }


    public function controllerDispatcher()
    {
        return new ControllerDispatcher();
    }


    public function methods()
    {
        return $this->method;
    }

    public function uri()
    {
        return $this->uri;
    }
}