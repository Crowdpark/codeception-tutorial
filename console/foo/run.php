<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seb
 * Date: 2/15/13
 * Time: 3:51 PM
 * To change this template use File | Settings | File Templates.
 */

require __DIR__ . "/../../vendor/autoload.php";
use Application\Bootstrap;
use Application\Cli\Foo\Dispatcher;

Bootstrap::getInstance()->init(Bootstrap::MODE_CLI);

$dispatcher = new Dispatcher();
$dispatcher->run();