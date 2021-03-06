<?php

namespace JuliaYatsko\course2\models;

use JuliaYatsko\course2\core\DBDriver;
use JuliaYatsko\course2\core\Validator;

class NewsModel extends BaseModel
{
    protected $table = 'news';
    protected $schema = [
        'id' => [
            'primary' => true,
            'type' => Validator::INTEGER
        ],
        'dt' => [
            'type' => 'date'
        ],
        'news_title' => [
            'type' => Validator::STRING,
            'length' => [5, 100],
            'not_blank' => true,
            'require' => true
        ],
        'news_content' => [
            'type' => Validator::STRING,
            'length' => [10, 300],
            'require' => true,
            'not_blank' => true,
        ],
        'is_moderate' => [
            'type' => Validator::INTEGER
        ]
    ];

    public function __construct(DBDriver $db, Validator $validator)
    {
        parent::__construct($db, $validator, $this->table);
        $this->validator->setRules($this->schema);
    }

////////////  $columns : dt=NOW(),
}