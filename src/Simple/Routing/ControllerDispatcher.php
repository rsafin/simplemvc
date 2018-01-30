<?php

namespace Simple\Routing;

class ControllerDispatcher
{
    public function dispatch(Controller $controller, $action)
    {
        //TODO: получение параметров из роута
        $parameters = [];

        if (method_exists($controller, 'callAction')) {
            return $controller->callAction($action, $parameters);
        }

        return $controller->{$action}(...array_values($parameters));
    }
}