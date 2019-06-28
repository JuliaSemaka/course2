<?php

namespace models;

use core\DBDriver;
use core\Exception\ModelIncorrectDataException;
use core\Validator;

class UsersModel extends BaseModel
{
    const MD5_ADD = 'wqwertry';
    protected $table = 'users';
    protected $schema = [
        'id' => [
            'primary' => true,
            'type' => Validator::INTEGER
        ],
        'user_name' => [
            'type' => Validator::STRING,
            'length' => [5, 50],
            'not_blank' => true,
            'require' => true
        ],
        'user_password' => [
            'type' => Validator::STRING,
            'length' => [5, 50],
            'require' => true,
            'not_blank' => true,
        ]
    ];

    public function __construct(DBDriver $db, Validator $validator)
    {
        parent::__construct($db, $validator, $this->table);
        $this->validator->setRules($this->schema);
    }

    public function signUp(array $field)
    {
        $this->validator->execute($field);

        if(!$this->validator->success) {
            throw new ModelIncorrectDataException($this->validator->errors);
        }

        $this->addNew([
            'user_name' => $this->validator->clean['user_name'],
            'user_password' => $this->getHash($this->validator->clean['user_password'])
        ], false);
    }

    public function signIn(array $field)
    {
        $user_name = $this->validator->clean['user_name'];
        $user_password = $this->getHash($this->validator->clean['user_password']);

        $this->validator->execute($field);

        if(!$this->validator->success) {
            throw new ModelIncorrectDataException($this->validator->errors);
        }

        if(!$this->db->select(
            $this->table,
            sprintf('user_name = \'%s\' AND user_password = \'%s\'', $user_name, $user_password),
            DBDriver::FETCH_ONE)) {
            throw new ModelIncorrectDataException(['no_such_user' => 'No such user']);
        }
    }

    public function getHash($password)
    {
        return md5($password . self::MD5_ADD);
    }
}