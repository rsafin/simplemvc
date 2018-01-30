<?php

use Simple\Routing\Router;
use Simple\Http\Request;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//TODO: внедрить сервис контейнер

require "../src/Simple/ClassLoader/ClassLoader.php";

$classLoader = new Simple\ClassLoader\ClassLoader(realpath(__DIR__.'/../'), ['src', 'app', 'routes']);
$classLoader->register();

$application = new Application;
$router = new Router;

$router->get('/', 'homeController@index');
$router->get('/show', 'homeController@show');

$kernel =  new Kernel($application, $router);
$kernel->handle(Request::capture());
