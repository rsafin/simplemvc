<?php

interface ServiceLocatorContract
{
    public function get(string $interface);
    public function has(string $interface);
}