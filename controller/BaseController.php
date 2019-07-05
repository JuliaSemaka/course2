<?php

namespace controller;

use core\Request;
use core\Exception\ErrorNotFoundException;

class BaseController
{
    protected $title;
    protected $content;
    protected $request;

    public function __construct(Request $request = null)
    {
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