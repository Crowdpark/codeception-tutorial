<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seb
 * Date: 2/15/13
 * Time: 4:06 PM
 * To change this template use File | Settings | File Templates.
 */


require __DIR__ . "/../../vendor/autoload.php";
use Application\Bootstrap;
use Application\Api\Router;

Bootstrap::getInstance()->init();

$router = new Router();
$router->addRoute(
    'Test.ping',
    '\\Application\\Api\\Service\\Test',
    'ping'
)
    ->setRequestText($router->fetchRequestText())
    ->route()
    ->sendResponse();
