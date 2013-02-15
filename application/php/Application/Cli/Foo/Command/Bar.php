<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seb
 * Date: 2/15/13
 * Time: 3:53 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Cli\Foo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use Application\Context;

class Bar extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this->setName('foo:bar')
            ->setDescription(
            'display helloworld message'
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        echo PHP_EOL . PHP_EOL;
        echo 'Hello World @ ' . __METHOD__;
        echo PHP_EOL . PHP_EOL;
    }


}
