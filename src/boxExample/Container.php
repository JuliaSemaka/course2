<?php

namespace box;

class Container
{
    private $container = [];

    public function set($name, \Closure $callback)
    {
        $this->container[$name] = $callback;
    }

    public function register(RegisterBoxInterface $box)
    {
        $box->register($this);
    }

    public function execute($name, ...$params)
    {
        if(!$this->container[$name]) {
            die('mistake');
        }

        return call_user_func_array($this->container[$name], $params);
    }
}