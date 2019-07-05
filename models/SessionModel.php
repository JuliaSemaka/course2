<?php

namespace models;

use core\DBDriver;
use core\Validator;
use core\Exception\ModelIncorrectDataException;

class SessionModel extends BaseModel
{
    protected $table = 'sessions';
    protected $schema = [
        'id' => [
            'primary' => true,
            'type' => Validator::INTEGER
        ],
        'id_user' => [
            'not_blank' => true,
            'require' => true,
            'type' => Validator::INTEGER
        ],
        'sid' => [
            'type' => Validator::STRING,
            'not_blank' => true,
            'require' => true
        ],
        'created_at' => [

        ],
        'updated_at' => [

        ]
    ];

    public function __construct(DBDriver $db, Validator $validator)
    {
        parent::__construct($db, $validator, $this->table);
        $this->validator->setRules($this->schema);
    }

    public function addSession($sid, $id)
    {
        $this->validator->execute(['sid' => $sid, 'id_user' => $id]);

        if(!$this->validator->success) {
            throw new ModelIncorrectDataException($this->validator->errors);
        }

        $this->addNew([
            'sid' => $this->validator->clean['sid'],
            'id_user' => $this->validator->clean['id_user']
        ], false);
    }

    public function getBySid($sid)
    {
        //SELECT users.id as id, user_name, user_password FROM sessions JOIN users ON sessions.id_user = users.id WHERE sid = '123456789'
        $sql = sprintf('SELECT * FROM %s JOIN %s ON %s = %s WHERE %s = \'%s\'', $this->table, 'users', 'sessions.id_user', 'users.id', 'sid', $sid);
        return $this->db->selectJoin($sql);
    }
}