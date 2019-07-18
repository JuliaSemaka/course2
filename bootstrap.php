<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ig0rbm\HandyBox\HandyBoxContainer;
use JuliaYatsko\course2\box\DBDriverBox;
use JuliaYatsko\course2\box\ModelsFactory;
use JuliaYatsko\course2\box\UserBox;
use JuliaYatsko\course2\box\SessionBox;
use JuliaYatsko\course2\Application;

$container = new HandyBoxContainer();
$app = new Application($container);

$container->register(new DBDriverBox());
$container->register(new ModelsFactory());
$container->register(new SessionBox());
$container->register(new UserBox());

return $app;