<?php

namespace JuliaYatsko\course2\box;

use Ig0rbm\HandyBox\HandyBoxContainer;
use Ig0rbm\HandyBox\HandyBoxInterface;
use JuliaYatsko\course2\models\SessionModel;
use JuliaYatsko\course2\models\UsersModel;
use JuliaYatsko\course2\core\Validator;

class ModelsFactory implements HandyBoxInterface
{
    public function register(HandyBoxContainer $container)
    {
        $container->factory('factory-models', function ($name) use ($container) {
            $model = sprintf('\\JuliaYatsko\\course2\\models\\%sModel', $name);

            return new $model(
                $container->get('db-driver'),
                new Validator()
            );
        });
    }
}