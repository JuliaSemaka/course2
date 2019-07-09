<?php

namespace Project\Phpblog\box;

use Ig0rbm\HandyBox\HandyBoxContainer;
use Ig0rbm\HandyBox\HandyBoxInterface;
use Project\Phpblog\core\User;
use Project\Phpblog\models\SessionModel;
use Project\Phpblog\models\UsersModel;
use Project\Phpblog\core\Validator;

class UserBox implements HandyBoxInterface
{
    public function register(HandyBoxContainer $container)
    {
        $container->factory('user', function ($request) use ($container) {
            return new User($container->fabricate('factory-models', 'Users'), $container->fabricate('factory-models', 'Session'), $request);
        });
    }
}