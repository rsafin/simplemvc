<?php

namespace Simple\Database;

class Config
{
    private $host;
    private $database;
    private $user;
    private $password;
    private $driver;
    private $charset;

    public function __construct(string $host, string $database, string $user, string $password, string $charset = 'utf8', string $driver = 'mysql')
    {
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->charset = $charset;
        $this->driver = $driver;
    }

    public function getHost() : string
    {
        return $this->host;
    }

    public function getDatabase() : string
    {
        return $this->database;
    }

    public function getUser() : string
    {
        return $this->user;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getDriver() : string
    {
        return $this->driver;
    }

    public function getCharset() : string
    {
        return $this->charset;
    }
}