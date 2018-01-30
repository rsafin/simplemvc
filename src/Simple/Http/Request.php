<?php

namespace Simple\Http;

class Request
{
    /**
     * @var Collections
     */
    private $query;

    /**
     * @var Collections
     */
    private $request;

    /**
     * @var Collections
     */
    private $server;

    private $method;

    public function __construct(array $query = [], array $request = [], array $server = [])
    {
        $this->initialize($query, $request, $server);
    }

    public function initialize(array $query = [], array $request = [], array $server = [])
    {
        $this->query = new Collections($query);
        $this->request = new Collections($request);
        $this->server = new Collections($server);
    }

    public static function capture()
    {
        return static::createFromGlobals();
    }

    public static function createFromGlobals()
    {
        return new static($_GET, $_POST, $_SERVER);
    }

    public function getMethod()
    {
        if (null === $this->method) {
            $this->method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
        }

        return $this->method;
    }

    public function getRequestUri()
    {
        return $this->server->get('REQUEST_URI');
    }
}