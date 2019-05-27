<?php
namespace core;

class DB
{
    private static $instance;

    public static function db_connect()
    {
        if(self::$instance === null){
            self::$instance = self::getPDO();
        }
        return self::$instance;
    }

    private static function getPDO()
    {
        $dsn = sprintf('%s:host=%s;dbname=%s', 'mysql', 'localhost', 'bdblog');
        $db = new \PDO($dsn, 'root', '');
        $db->exec('SET NAMES UTF8');
        return $db;
    }

//    public static function db_query($sql, $params = [])
//    {
//        $query = $this->db->prepare($sql);
//        $query->execute($params);
//
//        self::db_check_error($query);
//
//        return $query;
//    }
//
    public static function db_check_error($query)
    {
        $info = $query->errorInfo();

        if($info[0] != \PDO::ERR_NONE){
            exit($info[2]);
        }
    }
}