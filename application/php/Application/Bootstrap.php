<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seb
 * Date: 2/15/13
 * Time: 5:50 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application;

class Bootstrap
{

    const MODE_HTTP = 'MODE_HTTP';
    const MODE_CLI = 'MODE_CLI';

    /**
     * @var string
     */
    private $mode;

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

    /**
     * @return Context
     */
    public function getContext()
    {
        return Context::getInstance();
    }

    /**
     * @param string $mode
     * @return Bootstrap
     */
    public function init($mode = self::MODE_HTTP)
    {
        $this->mode = $mode;
        ini_set('display_errors', false);
        ini_set('html_errors', false);

        error_reporting(E_ALL | E_STRICT);

        set_error_handler(
            array(
                $this,
                'errorHandler'
            )
        );
        set_exception_handler(
            array(
                $this,
                'exceptionHandler'
            )
        );
        setlocale(LC_ALL, 'C');

        return $this;
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @throws \ErrorException
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {

        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    /**
     * @param \Exception $exception
     */
    public function exceptionHandler(\Exception $exception)
    {
        try {
            header('HTTP/1.1 500 Internal Server Error');
        } catch (\Exception $e) {
            // nop
        }

        echo 'Whoops! An Error occured. (EHF)';
    }


}
