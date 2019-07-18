<?php

namespace JuliaYatsko\course2\models;

use JuliaYatsko\course2\core\DBDriver;
use JuliaYatsko\course2\core\Validator;

class RoleModel extends BaseModel
{
    protected $schema = [
        'id' => [
            'primary' => true
        ],
        'name' => [
            'type' => 'string',
            'length' => [5, 35],
            'not_blank' => true,
            'require' => true
        ],
        'description' => [
            'type' => 'string',
            'length' => [0, 255]
        ],
        'user_id' => [
            'type' => 'integer'
        ]
    ];

    public function __construct(DBDriver $db, Validator $validator)
    {
        parent::__construct($db, $validator, 'role');
        $this->validator->setRules($this->schema);
    }

    public function checkPriv($priv, $userId)
    {
        //SELECT users.id as id, user_name, user_password FROM sessions JOIN users ON sessions.id_user = users.id WHERE sid = '123456789'

        $sql = 'SELECT
                roles.user_id AS user_id,
                roles.name AS role_name,
                privs.name AS priv_name
                FROM `privs`
                JOIN `privs2roles`
                ON `privs2roles`.`id_privs` = `privs`.`id`
				JOIN `roles`
					ON `roles`.`id` = `privs2roles`.`id_roles`
				WHERE `privs`.`name` = :name AND `roles`.`user_id` = :user_id';

        return $this->db->selectJoin($sql, ['name' => $priv, 'user_id' => $userId]);
    }
}