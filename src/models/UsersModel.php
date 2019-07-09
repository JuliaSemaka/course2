<?php

namespace Project\Phpblog\models;

use Project\Phpblog\core\DBDriver;
use Project\Phpblog\core\Exception\ModelIncorrectDataException;
use Project\Phpblog\core\Validator;

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
        $this->validator->execute($field);

        if(!$this->validator->success) {
            throw new ModelIncorrectDataException($this->validator->errors);
        }

        $user_name = $this->validator->clean['user_name'];
        $user_password = $this->getHash($this->validator->clean['user_password']);

        $user = $this->getByUser(sprintf('user_name = \'%s\' AND user_password = \'%s\'', $user_name, $user_password));

        if(!$user) {
            $errors['user_password'][] = sprintf('%s', 'Invalid email address or password');
            throw new ModelIncorrectDataException($errors);
        }

        return $user;
    }

    public function getByUser($user)
    {
        return $this->db->select($this->table, $user, DBDriver::FETCH_ONE);
    }

    public function getHash($password)
    {
        return md5($password . self::MD5_ADD);
    }
}