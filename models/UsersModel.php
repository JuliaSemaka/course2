<?php

namespace models;

use core\DB;

class UsersModel extends BaseModel
{
    protected $table = 'users';

    public function __construct(\PDO $db)
    {
        parent::__construct($db, $this->table);
    }

    public function updateById($id, $user_name, $password)
    {
        $sql = sprintf('UPDATE %s SET user_name=:n, user_password=:p WHERE id=:id', $this->table);
        $query = $this->db->prepare($sql);
        $query->execute(['n' => $user_name, 'p' => $password, 'id'=>$id]);
    }

    public function addUser($user_name, $password)
    {
        $sql = sprintf('INSERT INTO %s (user_name, user_password) VALUES (:n,:p)', $this->table);
        $query = $this->db->prepare($sql);
        $query->execute(['n' => $user_name, 'p' => $password]);
    }
}