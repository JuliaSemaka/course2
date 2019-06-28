<?php

namespace core;

use models\SessionModel;
use models\UsersModel;
use core\Exception\ModelIncorrectDataException;
use core\Request;

class User
{
    private $mUser;
    private $mSession;

    public function __construct(UsersModel $mUser, SessionModel $mSession)
    {
        $this->mUser = $mUser;
        $this->mSession = $mSession;
    }

    public function signUp(array $fields)
    {
        if(!$this->comparePass($fields)) {
            $errors =[];
            $errors['user_password_repeat'][] = sprintf('%s', 'Does not match the password');
            throw new ModelIncorrectDataException($errors);
        }
        $this->mUser->signUp($fields);
    }

    public function signIn(array $fields)
    {
        $this->mUser->signIn($fields);

        if (isset($fields['remember'])) {
            setcookie('user', $fields['user_name'], time()+3600*24*7, '/');
            setcookie('password', $this->mUser->getHash($fields['user_password']), time()+3600*24*7, '/');
        }

        $_SESSION['sid'] = true;
        $_SESSION['name'] = $fields['user_name'];
        $_SESSION['pass'] = $this->mUser->getHash($fields['user_password']);
    }

    public function isAuth(Request $request)
    {
        if ($request['sid'] && $this->mSession->getBySid('sid') === true) {

        }
    }

    private function comparePass(array $field)
    {
        return $field['user_password'] === $field['user_password_repeat'];
    }
}