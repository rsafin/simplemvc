<?php

namespace Simple\Http;

class Collections
{
    private $parameters;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    public function all() : array
    {
        return $this->parameters;
    }

    public function key() : array
    {
        return array_keys($this->parameters);
    }

    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $this->parameters[$key] : $default;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->parameters);
    }
}