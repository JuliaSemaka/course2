<?php

namespace JuliaYatsko\course2\core;

class DBDriver
{
    const FETCH_ALL = 'all';
    const FETCH_ONE = 'one';

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select($table, $where = '', $fetch = self::FETCH_ALL)
    {
        $sql = sprintf('SELECT * FROM %s WHERE %s', $table, $where);
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $fetch === self::FETCH_ALL ? $query->fetchAll() : $query->fetch();
    }

    public function selectJoin($sql, $params = null)
    {
        $query = $this->pdo->prepare($sql);
        isset($params) ? $query->execute($params) : $query->execute();
        return $query->fetch();
    }

    public function insert($table, array $params)
    {
        $columns = sprintf('(%s)', implode(', ', array_keys($params)));
        $masks = sprintf('(:%s)', implode(', :', array_keys($params)));

        $sql = sprintf('INSERT INTO %s %s VALUES %s', $table, $columns, $masks);

        $query = $this->pdo->prepare($sql);
        $query->execute($params);

        return $this->pdo->lastInsertId();
    }

    public function update($table, array $params, $where)
    {
        $columns = '';
        foreach ($params as $key => $value){
            $columns .=  sprintf('%s=:%s, ', $key, $key);
        }

        $columns = substr($columns, 0, -2);

        $sql = sprintf('UPDATE %s SET %s WHERE %s', $table, $columns, $where);

        $query = $this->pdo->prepare($sql);

        $query->execute($params);
    }

    public function delete($table, $where)
    {
        $sql = sprintf('DELETE FROM %s WHERE %s', $table, $where);
        $query = $this->db->prepare($sql);
        $query->execute();
    }
}