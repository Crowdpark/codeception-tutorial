<?php
/**
 * Created by JetBrains PhpStorm.
 * User: seb
 * Date: 2/15/13
 * Time: 4:38 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Api;

class Router
{

    /**
     * @var array
     */
    protected $routes = array();
    /**
     * @var null|mixed
     */
    protected $result = null;
    /**
     * @var null|\Exception
     */
    protected $error = null;

    /**
     * @var string
     */
    protected $requestText = '';
    /**
     * @var string
     */
    protected $responseText = '';
    /**
     * @var null|array
     */
    protected $requestData = null;
    /**
     * @var null|array
     */
    protected $responseData = null;

    /**
     * @param string $rpcMethod
     * @param string $serviceClass
     * @param string $serviceMethod
     * @return self
     */
    public function addRoute($rpcMethod, $serviceClass, $serviceMethod)
    {
        $this->routes[$rpcMethod] = array(
            'rpcMethod' => $rpcMethod,
            'serviceClass' => $serviceClass,
            'serviceMethod' => $serviceMethod,
        );

        return $this;
    }

    /**
     * @return string
     */
    public function fetchRequestText()
    {
        $requestText = (string)file_get_contents("php://input");

        return $requestText;
    }


    /**
     * @param string $text
     * @return Router
     */
    public function setRequestText($text)
    {
        $this->requestText = (string)$text;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestText()
    {
        return (string)$this->requestText;
    }

    /**
     * @return string
     */
    public function getResponseText()
    {
        return (string)$this->responseText;
    }

    /**
     * @return array|null
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * @return mixed|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return \Exception|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return ($this->error instanceof \Exception);
    }

    /**
     * @return self
     */
    public function sendResponse()
    {
        if ($this->hasError()) {
            try {
                header("HTTP/1.0 500 Internal Server Error");
            } catch (\Exception $e) {
                // nop
            }
        }

        echo $this->getResponseText();

        return $this;
    }

    /**
     * @return self
     */
    public function route()
    {
        $this->result = null;
        $this->error = null;
        $this->requestData = null;
        $this->responseData = null;

        $result = null;
        $error = null;
        try {
            $result = $this->routeRequest();
        } catch (\Exception $e) {
            $error = array(
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'stackTrace' => $e->getTraceAsString(),
            );
        }
        $responseData = array(
            'result' => $result,
            'error' => $error,
        );

        $responseText = null;
        try {
            $responseText = json_encode($responseData);
        } catch (\Exception $e) {
            $result = null;
            $error = array(
                'message' => 'json encode rpc.response failed',
            );
            $responseData = array(
                'result' => $result,
                'error' => $error,
            );
            $responseText = json_encode($responseData);
        }

        $this->result = $result;
        $this->error = $error;
        $this->responseData = $responseData;
        $this->responseText = (string)$responseText;

        return $this;
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    protected function routeRequest()
    {
        $result = null;

        $method = null;
        $params = null;

        $requestText = $this->getRequestText();
        $requestData = json_decode($requestText, true);

        if (!is_array($requestData)) {

            throw new \Exception('Invalid rpc.method');
        }
        // rpc.method
        if (!isset($requestData['method'])) {

            throw new \Exception('Invalid rpc.method');
        }
        $method = $requestData['method'];
        if (!is_string($method)) {
            throw new \Exception('Invalid rpc.method');
        }
        // rpc.params
        if (!isset($requestData['params'])) {
            $params = array();
        } else {
            $params = $requestData['params'];
        }
        if (!is_array($params)) {

            throw new \Exception('Invalid rpc.params');
        }
        // rpc.method ---> route
        $routes = $this->routes;
        if (!array_key_exists($method, $routes)) {

            throw new \Exception('Invalid rpc.method. Route not found');
        }
        $route = $routes[$method];

        $serviceClassName = $route['serviceClass'];
        $serviceMethodReflector = null;
        try {
            $serviceReflector = new \ReflectionClass($serviceClassName);
            $serviceMethodReflector = $serviceReflector->getMethod(
                $route['serviceMethod']
            );

            $serviceInstance = $serviceReflector->newInstanceArgs(array());

        } catch (\Exception $e) {

            throw new \Exception('Invalid rpc.method Service/Method not found');
        }

        $result = $serviceMethodReflector->invokeArgs(
            $serviceInstance,
            $params
        );

        return $result;
    }

}
