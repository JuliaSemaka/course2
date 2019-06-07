<?php

namespace models;

use core\DBDriver;
use core\Validator;

class UsersModel extends BaseModel
{
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
        ],
        'user_password_repeat' => [
            'must_be_equal' => 'user_password'
        ]
    ];

    public function __construct(DBDriver $db, Validator $validator)
    {
        parent::__construct($db, $validator, $this->table);
        $this->validator->setRules($this->schema);
    }
}