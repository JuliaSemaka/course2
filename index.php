<?php

require_once __DIR__ . '/bootstrap.php';

use JuliaYatsko\course2\core\DB;
use JuliaYatsko\course2\models\UsersModel;
use JuliaYatsko\course2\models\NewsModel;
use JuliaYatsko\course2\controller\NewsController;
use JuliaYatsko\course2\controller\BaseController;
use JuliaYatsko\course2\core\Request;
use JuliaYatsko\course2\core\Exception\ErrorNotFoundException;
define("DEV", "true");

//function __autoload($classname) {
//    include_once __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
//}

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
    case 'users':
        $controller = 'Users';
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        throw new ErrorNotFoundException();
        break;
}

$id = false;

if(isset($uri[1]) && is_numeric($uri[1])){
    $id = $uri[1];
    $uri[1] = 'one';
}

$action = isset($uri[1]) && $uri[1] != '' && is_string($uri[1]) ? $uri[1] : 'index';

if(strpos($action, '_')) {
    $actionParts = explode('_', $action);
    for ($i=1; $i<count($actionParts); $i++) {
        if (!isset($actionParts[$i])) {
            continue;
        }

        $actionParts[$i] = ucfirst($actionParts[$i]);
    }

    $action = implode('', $actionParts);
}

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

$request = new Request($_GET, $_POST, $_SERVER, $_COOKIE, $_FILES, $_SESSION);

$controller = sprintf('JuliaYatsko\course2\controller\%sController', $controller);
$controller = new $controller($container, $request);
    $controller->$action();
} catch (\Exception $e) {
    $controller = sprintf('JuliaYatsko\course2\controller\%sController', 'News');
    $controller = new $controller($container);
    $controller->errorHandler($e->getMessage(), $e->getTrace());
}
$controller->render();
