<?php
namespace JuliaYatsko\course2\core;

class DB
{
    private static $instance;

    private function __construct()
    {
    }

    private function __clone() {}
    private function __sleep() {}
    private function __wakeup() {}

    
    public static function db_connect()
    {
        if(self::$instance === null){
            self::$instance = self::getPDO();
        }
        return self::$instance;
    }

    private static function getPDO()
    {
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        $dsn = sprintf('%s:host=%s;dbname=%s', 'mysql', 'localhost', 'bdblog');
        $db = new \PDO($dsn, 'root', '', $opt);
        $db->exec('SET NAMES UTF8');
        return $db;
    }
}