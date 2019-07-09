<?php

namespace JuliaYatsko\course2\box;

use Ig0rbm\HandyBox\HandyBoxContainer;
use Ig0rbm\HandyBox\HandyBoxInterface;
use JuliaYatsko\course2\core\User;
use JuliaYatsko\course2\models\SessionModel;
use JuliaYatsko\course2\models\UsersModel;
use JuliaYatsko\course2\core\Validator;

class UserBox implements HandyBoxInterface
{
    public function register(HandyBoxContainer $container)
    {
        $container->factory('user', function ($request) use ($container) {
            return new User($container->fabricate('factory-models', 'Users'), $container->fabricate('factory-models', 'Session'), $request);
        });
    }
}