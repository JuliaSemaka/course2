<?php

namespace JuliaYatsko\course2\box;

use Ig0rbm\HandyBox\HandyBoxContainer;
use Ig0rbm\HandyBox\HandyBoxInterface;
use JuliaYatsko\course2\core\http\Session;

class SessionBox implements HandyBoxInterface
{
    public function register(HandyBoxContainer $container)
    {
        $container->service('http-session', function () {
            return new Session();
        });
    }
}