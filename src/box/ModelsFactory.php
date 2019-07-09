<?php

namespace Project\Phpblog\box;

use Ig0rbm\HandyBox\HandyBoxContainer;
use Ig0rbm\HandyBox\HandyBoxInterface;
use Project\Phpblog\models\SessionModel;
use Project\Phpblog\models\UsersModel;
use Project\Phpblog\core\Validator;

class ModelsFactory implements HandyBoxInterface
{
    public function register(HandyBoxContainer $container)
    {
        $container->factory('factory-models', function ($name) use ($container) {
            $model = sprintf('\\Project\\Phpblog\\models\\%sModel', $name);

            return new $model(
                $container->get('db-driver'),
                new Validator()
            );
        });
    }
}