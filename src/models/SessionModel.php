<?php

namespace JuliaYatsko\course2\models;

use JuliaYatsko\course2\core\DBDriver;
use JuliaYatsko\course2\core\Validator;
use JuliaYatsko\course2\core\Exception\ModelIncorrectDataException;

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
            'type' => 'timestamp'

        ],
        'updated_at' => [
            'type' => 'timestamp'
        ]
    ];

    protected $sid;

    public function __construct(DBDriver $db, Validator $validator)
    {
        parent::__construct($db, $validator, $this->table);
        $this->validator->setRules($this->schema);
    }

    public function set($sid, $id)
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

    public function update($sid)
    {
        return $this->db->update($this->table,
            ['updated_at' => date('Y-m-d H:i:s')],
            sprintf('sid="%s"', $sid));
    }

    public function getSid()
    {
        return $this->sid;
    }

    protected function genSid()
    {
        $pattern = '1234567890qwertyuiopsdfghjklzxcvbnmgdfvRTGFFHUJKYTJDHY,KMBHJNJ';
        $strlen = strlen($pattern) - 1;
        $sid = '';

        for ($i = 0; $i < 20; $i++) {
            $char = mt_rand(0, $strlen);
            $sid .= $pattern[$char];
        }

        return $sid;
    }

    public function getSidHash($sid)
    {
        $md5 = md5($sid . UsersModel::MD5_ADD);
        $this->sid = substr($md5, 1, 10);
        return $this->sid;
    }

    public function getBySid($sid)
    {
        //SELECT users.id as id, user_name, user_password FROM sessions JOIN users ON sessions.id_user = users.id WHERE sid = '123456789'
        $sql = sprintf('SELECT *
					FROM %s 
					JOIN %s 
					ON %s = %s 
					WHERE %s = \'%s\'',
            $this->table, 'users', 'sessions.id_user', 'users.id', 'sid', $sid);
        return $this->db->selectJoin($sql);
    }
}