<?php

namespace core;

use models\UsersModel;
use core\Exception\ModelIncorrectDataException;

class User
{
    private $mUser;

    public function __construct(UsersModel $mUser)
    {
        $this->mUser = $mUser;
    }

    public function signUp(array $fields)
    {
        if(!$this->comparePass($fields)) {
            throw new ModelIncorrectDataException(['user_password_repeat' => 'Does not match the password']);
        }
        $this->mUser->signUp($fields);
    }

    private function comparePass(array $field)
    {
        return $field['user_password'] === $field['user_password_repeat'];
    }
}