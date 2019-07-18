<?php

namespace JuliaYatsko\course2\box;

use Ig0rbm\HandyBox\HandyBoxContainer;
use Ig0rbm\HandyBox\HandyBoxInterface;
use JuliaYatsko\course2\core\User;
use JuliaYatsko\course2\core\http\Request;


class UserBox implements HandyBoxInterface
{
    public function register(HandyBoxContainer $container)
    {
        $container->service('user', function() use($container) {

            return new User(
                $container->fabricate('factory-models', 'Users'),
                $container->fabricate('factory-models', 'Session'),
                $container->fabricate('factory-models', 'Role'),
                $container->get('http-session')
            );
        });
    }
}