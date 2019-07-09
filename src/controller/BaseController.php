<?php

namespace Project\Phpblog\controller;

use Project\Phpblog\core\Request;
use Project\Phpblog\core\Exception\ErrorNotFoundException;
use Ig0rbm\HandyBox\HandyBoxContainer;

class BaseController
{
    protected $title;
    protected $content;

    protected $request;
    protected $container;

    public function __construct(HandyBoxContainer $container, Request $request = null)
    {
        $this->container = $container;
        $this->request = $request;
        $this->title = 'PHP2';
        $this->content = '';
    }

    public function __call($name, $arguments)
    {
        throw new ErrorNotFoundException();
    }

    public function render()
    {
        echo $this->build(NewsController::ROOT . 'main.html.php', [
            'title' => $this->title,
            'content' => $this->content
        ]);
    }

    public function errorHandler($message, $trace)
    {
        $this->title = $message;
        $err['message'] = $message;
        if (DEV) {
            $err['trace'] = $trace;
        }
        $this->content = $this->build(NewsController::ROOT . 'errorEx.html.php', ['err' => $err]);
    }

    protected function build($template, array $params = [])
    {
        ob_start();
        extract($params);
        include_once $template;
        return ob_get_clean();
    }

    protected function redirect($uri)
    {
        header(sprintf('Location: %s', $uri));
        exit();
    }
}