<?php

namespace JuliaYatsko\course2\core\http;

use Ig0rbm\HandyBag\HandyBag;

class Request
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    private $get;
    private $post;
    private $server;
    private $cookie;
    private $file;

    public function __construct($get, $post, $server, $cookie, $file)
    {
        $this->get = new HandyBag($get);
        $this->post = new HandyBag($post);
        $this->server = new HandyBag($server);
        $this->cookie = new HandyBag($cookie);
        $this->file = new HandyBag($file);
    }

    public function get()
    {
        return $this->get;
    }

    public function cookie()
    {
        return $this->cookie;
    }

    public function post()
    {
        return $this->post;
    }

    public function server()
    {
        return $this->server;
    }

    public function isPost()
    {
        return $this->server->get('REQUEST_METHOD') === self::METHOD_POST;
    }
}