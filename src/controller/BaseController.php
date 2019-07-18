<?php

namespace JuliaYatsko\course2\controller;

use JuliaYatsko\course2\core\http\Response;
use JuliaYatsko\course2\core\http\Request;
use JuliaYatsko\course2\core\Exception\ErrorNotFoundException;
use Ig0rbm\HandyBox\HandyBoxContainer;

class BaseController
{
    protected $title;
    protected $content;

    protected $request;
    protected $response;
    protected $session;
    protected $container;

    public function __construct(Request $request, Response $response, HandyBoxContainer $container)
    {
        $this->container = $container;
        $this->request = $request;
        $this->response = $response;

        $this->title = 'PHP2';
        $this->content = '';
    }

    public function getFullTemplate()
    {
        echo $this->build(NewsController::ROOT . 'main.html.php', [
            'title' => $this->title,
            'content' => $this->content
        ]);
    }

    protected function build($template, array $params = [])
    {
        ob_start();
        extract($params);
        include_once $template;

        return ob_get_clean();
    }

//    public function errorHandler($message, $trace)
//    {
//        $this->title = $message;
//        $err['message'] = $message;
//        if (DEV) {
//            $err['trace'] = $trace;
//        }
//        $this->content = $this->build(NewsController::ROOT . 'errorEx.html.php', ['err' => $err]);
//    }
//
//    protected function redirect($uri)
//    {
//        header(sprintf('Location: %s', $uri));
//        exit();
//    }
}