<?php

namespace models;

use core\DBDriver;
use core\Validator;

class SessionModel extends BaseModel
{
    protected $table = 'session';
    protected $schema = [
        'id' => [
            'primary' => true,
            'type' => Validator::INTEGER
        ],
        'id_user' => [
            'primary' => true,
            'type' => Validator::INTEGER
        ],
        'sid' => [
            'type' => Validator::STRING,
            'length' => [5, 50],
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
}