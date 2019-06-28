<?php

class Router
{
    private $routeCollection = [];

    public function addRoute($uri, Closure $closure)
    {
        $this->routeCollection[$uri] = $closure;
    }

    public function get($uri, Closure$closure)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->routeCollection[$uri] = $closure;
        }

        $arr = explode('/', $uri);

    }

    public function post($uri, Closure$closure)
    {

    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (!isset($this->routeCollection[$uri])) {
            die('error 404');
        }

        $this->routeCollection[$uri]();
    }
}

$router = new Router();

$router->addRoute('/', function (){
    echo 'Main page';
});

$router->addRoute('/router', function () {
    echo 'Page router';
});

$router->run();




class EventDispatcher
{
    private $collection = [];

    public function addEvent($name, Closure $closure)
    {
        $this->collection[$name] = $closure;
    }

    public function fire($name, array $params = [])
    {
        if (!isset($this->collection[$name])) {
            return false;
        }

        call_user_func_array($this->collection[$name], $params);
    }
}

$ed = new EventDispatcher();

$ed->addEvent('five', function ($a, $b) {
    echo 'FIVE<br>';
    echo $a * $b . '<br>';
});

$user['name'] = 'Vasya';

$ed->addEvent('ten', function ($number) use ($user) {
    echo 'Hello, ' . $user['name'] .'<br>';
    echo '<strong>' . $number . '</strong><br>';
});

do {
    $number = mt_rand(0, 15);

    if ($number = 5) {
        $ed->fire('five', [2, 100]);
    } elseif ($number = 10) {
        $ed->fire('ten', $number);
    } else {
        echo $number . '<br>';
    }
} while ($number != 14);