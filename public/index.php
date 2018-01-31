<?php

use Simple\Routing\Router;
use Simple\Http\Request;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//TODO: внедрить сервис контейнер
//TODO: внедрить обработчик ошибок

require "../src/Simple/ClassLoader/ClassLoader.php";

function dd($vars)
{
    echo "<pre>";
    print_r($vars);
    echo "</pre>";
    die();
}

$classLoader = new Simple\ClassLoader\ClassLoader(realpath(__DIR__.'/../'), ['src', 'app', 'routes']);
$classLoader->register();

$application = new Application;
$router = new Router;

$router->get('/', 'homeController@index');
$router->get('/show', 'homeController@show');
$router->get('/show/{id}/', 'homeController@show');
$router->get('/news/{id}/comment/{id}', 'homeController@show');

$request = Request::capture();

Application::store('request', $request);

$kernel =  new Kernel($application, $router);
$response = $kernel->handle($request);
