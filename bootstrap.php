<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ig0rbm\HandyBox\HandyBoxContainer;
use Project\Phpblog\box\DBDriverBox;
use Project\Phpblog\box\ModelsFactory;
use Project\Phpblog\box\UserBox;

session_start();

$container = new HandyBoxContainer();
$container->register(new DBDriverBox());
$container->register(new ModelsFactory());
$container->register(new UserBox());