<?php
//CREATE DATABASE mydatabase CHARACTER SET utf8 COLLATE utf8_general_ci;
namespace Simple\Database;

class Connection
{
    private $connection;

    public function __construct(Config $config)
    {
        $dsn = sprintf('%s:host=%s;dbname=%s;charset=%s',
                $config->getDriver(),
                $config->getHost(),
                $config->getDatabase(),
                $config->getCharset()
            );

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->connection = new \PDO($dsn, $config->getUser(), $config->getPassword(), $options);
    }

    public function getConnection() : \PDO
    {
        return $this->connection;
    }
}