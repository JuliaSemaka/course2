<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ig0rbm\HandyBox\HandyBoxContainer;
use JuliaYatsko\course2\box\DBDriverBox;
use JuliaYatsko\course2\box\ModelsFactory;
use JuliaYatsko\course2\box\UserBox;

session_start();

$container = new HandyBoxContainer();
$container->register(new DBDriverBox());
$container->register(new ModelsFactory());
$container->register(new UserBox());