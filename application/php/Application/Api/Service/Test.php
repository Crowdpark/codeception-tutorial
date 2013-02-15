<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seb
 * Date: 2/15/13
 * Time: 5:21 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Api\Service;

class Test
{

    /**
     * @return bool
     */
    public function ping()
    {
        return true;
    }

    /**
     * @throws \Exception
     */
    public function error()
    {

        throw new \Exception('FooBarException at ' . __METHOD__);
    }
}
