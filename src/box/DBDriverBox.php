<?php

namespace JuliaYatsko\course2\box;

use Ig0rbm\HandyBox\HandyBoxContainer;
use Ig0rbm\HandyBox\HandyBoxInterface;
use JuliaYatsko\course2\core\DBDriver;
use JuliaYatsko\course2\core\DB;

class DBDriverBox implements HandyBoxInterface
{
    public function register(HandyBoxContainer $container)
    {
        $container->service('db-driver', function () {
            return new DBDriver(DB::db_connect());
        });
    }
}