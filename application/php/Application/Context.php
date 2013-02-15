<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seb
 * Date: 2/15/13
 * Time: 3:46 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application;

class Context
{

    /**
     * @var self
     */
    private static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}
