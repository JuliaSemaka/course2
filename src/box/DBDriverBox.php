<?php

namespace Project\Phpblog\box;

use Ig0rbm\HandyBox\HandyBoxContainer;
use Ig0rbm\HandyBox\HandyBoxInterface;
use Project\Phpblog\core\DBDriver;
use Project\Phpblog\core\DB;

class DBDriverBox implements HandyBoxInterface
{
    public function register(HandyBoxContainer $container)
    {
        $container->service('db-driver', function () {
            return new DBDriver(DB::db_connect());
        });
    }
}