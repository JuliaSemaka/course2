<?php

namespace JuliaYatsko\course2\core;

class Request
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    private $get;
    private $post;
    private $server;
    private $cookie;
    private $file;
    private $session;

    public function __construct($get, $post, $server, $cookie, $file, $session)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
        $this->cookie = $cookie;
        $this->file = $file;
        $this->session = $session;
    }

    public function get($key = null)
    {
        return $this->getMethod($this->get, $key);
    }

    public function post($key = null)
    {
        return $this->getMethod($this->post, $key);
    }

    public function cookie($key = null)
    {
        return $this->getMethod($this->cookie, $key);
    }

    public function session($key = null)
    {
        return $this->getMethod($this->session, $key);
    }

    private function getMethod($method, $key = null)
    {
        if (!$key) {
            return $method;
        }
        if (isset($method[$key])) {
            return $method[$key];
        }
        return null;
    }

    public function isGet()
    {
        return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
    }

    public function isPost()
    {
        return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
    }
}