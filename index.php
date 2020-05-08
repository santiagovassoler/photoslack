<?php

use PhotoSlack\Repository\ImageFactory;
use PhotoSlack\Repository\MessageFactory;
use PhotoSlack\Repository\MessageRepository;
use PhotoSlack\Repository\ReactionFactory;

loadAutoload();
router(getRequest());


function loadAutoload()
{
    try {
        require_once __DIR__.'/vendor/autoload.php';
    } catch (\Exception $e) {
        $e->getMessage();
        exit(1);
    }
}

function getRequest()
{
    $url = $_SERVER['REQUEST_URI'];
    $explode_url = explode('/', $url);
    $explode_url = array_slice($explode_url, 1);

    return $explode_url ;

}

function router($request)
{
    $action = $request[0];
    $param = (count($request) > 1) ? $request[1] : '' ;

    switch ($action)
    {
        case '' :
        case '/':
            $controllerName = '\PhotoSlack\Controller\MessageController';
            $action = 'index';
            break;
        case 'd':
            $controllerName = '\PhotoSlack\Controller\MessageController';
            $action = 'show';
            break;
        default :
            http_response_code(404);
            echo "<h1>404 PAGE NOT FOUND</h1>";
            echo "<h1><a>GO HOME: <a href='/'> 🏠</a></h1>";
            die();
            break;
    }

    $controller =
        new $controllerName(
        new MessageRepository(
        new ReactionFactory,
        new MessageFactory(
        new ImageFactory
     )));
    $controller->$action($param);
}
