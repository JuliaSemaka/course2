<?php

namespace Project\Phpblog\box;

use Project\Phpblog\Content;
use Project\Phpblog\Container;
use Project\Phpblog\TagBuilder;
use Project\Phpblog\TagBuilderBox;
use Project\Phpblog\RegisterBoxInterface;

//$content = new Content(123);
//$tagBuilder = new TagBuilderBox($content);

$container = new Container();
$container->register(new TagBuilderBox());
$model = $container->execute('UserModel');
$session = $container->execute('SessionModel');
$user = new User($model, $session, $this->request);