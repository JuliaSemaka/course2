<?php

use core\DB;
use models\UsersModel;
use models\NewsModel;
use controller\NewsController;
use controller\BaseController;
define("DEV", "true");

function __autoload($classname) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
}

session_start();

$uri = explode('/', $_GET['chpu']);
$end = count($uri) - 1;

if($uri[$end] === '') {
    unset($uri[$end]);
    $end--;
}

$controller = isset($uri[0]) && $uri[0] !== '' ? $uri[0] : 'news';

try {
switch ($controller) {
    case 'news':
        $controller = 'News';
        break;
    case 'user':
        $controller = 'User';
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        throw new \core\Exception\ErrorNotFoundException();
        break;
}

$id = false;

if(isset($uri[1]) && is_numeric($uri[1])){
    $id = $uri[1];
    $uri[1] = 'one';
}

$action = isset($uri[1]) && $uri[1] != '' && is_string($uri[1]) ? $uri[1] : 'index';
$action = sprintf('%sAction', $action);

//if(!method_exists(sprintf('controller\%sController', $controller), $action)){
//    header("HTTP/1.0 404 Not Found");
//    $action = 'err404';
//}

if(!$id){
    $id = isset($uri[2]) && is_numeric($uri[2]) ? $uri[2] : false;
}

if($id){
    $_GET['id'] = $id;
}

$request = new core\Request($_GET, $_POST, $_SERVER, $_COOKIE, $_FILES, $_SESSION);

$controller = sprintf('controller\%sController', $controller);
$controller = new $controller($request);
    $controller->$action();
} catch (\Exception $e) {
    $controller = sprintf('controller\%sController', 'News');
    $controller = new $controller();
    $controller->errorHandler($e->getMessage(), $e->getTrace());
}
$controller->render();

die();