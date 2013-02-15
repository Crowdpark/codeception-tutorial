<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seb
 * Date: 2/15/13
 * Time: 3:52 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Cli\Foo;


use Symfony\Component\Console\Application;
use Application\Cli\Foo\Command\Bar;

class Dispatcher
{

    /**
     *
     */
    public function run()
    {
        $app = new Application();
        $app->add(new Bar());
        $app->run();
    }


}
