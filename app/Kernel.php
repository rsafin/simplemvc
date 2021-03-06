<?php

use Simple\Routing\Router;
use Simple\Http\Request;

class Kernel
{
    private $router;
    private $application;

    public function __construct(Application $application, Router $router)
    {
        $this->application = $application;
        $this->router = $router;
    }

    public function handle(Request $request)
    {
        $this->bootstrap();
        return $this->dispatchToRouter($request);
    }


    private function dispatchToRouter($request)
    {
        return $this->router->dispatch($request);
    }

    private function bootstrap()
    {
        $this->application->bootstrap();
    }

}