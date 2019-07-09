<?php

namespace Project\Phpblog\core;

class Response
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    private $get;
    private $post;
    private $server;
    private $cookie;
    private $file;
    private $session;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->cookie = $_COOKIE;
        $this->session = $_SESSION;
        $this->server = $_SERVER;
        $this->file = $_FILES;
    }

    public function setGet($key, $value)
    {
        return $this->setMethod($this->get, $key, $value);
    }

    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
//        return $this->setMethod($this->session, $key, $value);
    }

    public function setCookie($key, $value)
    {
        return setcookie($key, $value, time()+3600*24*7, '/');
    }

    private function setMethod($method, $key, $value)
    {
        $method[$key] = $value;
    }
}