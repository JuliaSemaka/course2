<?php

namespace Project\Phpblog\core;

use Project\Phpblog\models\SessionModel;
use Project\Phpblog\models\UsersModel;
use Project\Phpblog\core\Exception\ModelIncorrectDataException;
use Project\Phpblog\core\Request;
use Project\Phpblog\core\Response;

class User
{
    private $mUser;
    private $mSession;
    private $request;
    private $response;

    public function __construct(UsersModel $mUser, SessionModel $mSession, Request $request)
    {
        $this->mUser = $mUser;
        $this->mSession = $mSession;
        $this->request = $request;
        $this->response = new Response();
    }

    public function signUp(array $fields)
    {
        if ($this->mUser->getByUser(sprintf('user_name = \'%s\'', $fields['user_name']))) {
            $errors['user_name'][] = sprintf('%s', 'User with the same name already exists');
            throw new ModelIncorrectDataException($errors);
        }

        if (!$this->comparePass($fields)) {
            $errors['user_password_repeat'][] = sprintf('%s', 'Does not match the password');
            throw new ModelIncorrectDataException($errors);
        }

        $this->mUser->signUp($fields);
    }

    public function signIn(array $fields)
    {
        $user = $this->mUser->signIn($fields);

        if (isset($fields['remember']) && isset($fields['user_name']) && isset($fields['user_password'])) {
            $this->response->setCookie('user', $fields['user_name']);
        }

        $sid = $this->getSidHash($fields['user_name']);
        if (!$this->mSession->getBySid($sid)) {
            $this->mSession->addSession($sid, $user['id']);
        }
        if (!$this->request->session('sid')) {
            $this->response->setSession('sid', $sid);
        }
    }

    public function isAuth()
    {
        $sid = $this->request->session('sid');
        $cookieUser = $this->request->cookie('user');

        if ($sid) {
            if (!$this->mSession->getBySid($sid) && $cookieUser) {
                $user = $this->mUser->getByUser(sprintf('user_name = \'%s\'', $cookieUser));
                $this->mSession->addSession($sid, $user['id']);
            }

            return true;
        } elseif ($cookieUser) {
            $sid = $this->getSidHash($cookieUser);
            $user = $this->mUser->getByUser(sprintf('user_name = \'%s\'', $cookieUser));
            $this->response->setSession('sid', $sid);

            if ($user && $sid && !$this->mSession->getBySid($sid)) {
                $this->mSession->addSession($sid, $user['id']);
            }

            return true;
        } else {
            return false;
        }
        //SELECT users.id as id, user_name, user_password FROM sessions JOIN users ON sessions.id_user = users.id WHERE sid = '123456789'
    }

    public function getSidHash($sid)
    {
        $md5 = md5($sid . UsersModel::MD5_ADD);
        return substr($md5, 1, 10);
    }

    private function comparePass(array $field)
    {
        return $field['user_password'] === $field['user_password_repeat'];
    }
}