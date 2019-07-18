<?php

namespace JuliaYatsko\course2\core;

use JuliaYatsko\course2\core\http\Response;
use JuliaYatsko\course2\models\SessionModel;
use JuliaYatsko\course2\models\UsersModel;
use JuliaYatsko\course2\core\Exception\ModelIncorrectDataException;
use JuliaYatsko\course2\core\http\Request;
use JuliaYatsko\course2\core\http\Session;
use JuliaYatsko\course2\core\http\Cookie;
use JuliaYatsko\course2\models\RoleModel;

class User
{
    private $mUser;
    private $mSession;
    private $mRole;
    private $session;
    private $request;
    private $response;

    public $current = null;

    public function __construct(UsersModel $mUser, SessionModel $mSession, RoleModel $mRole, Session $session)
    {
        $this->mUser = $mUser;
        $this->mSession = $mSession;
        $this->mRole = $mRole;
        $this->session = $session;
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

        $id = $this->mUser->signUp($fields);

        //!!!!!!!!!!!2 строки ниже происходит ошибка!!!!!!!
        $this->mSession->set($this->mSession->getSidHash($fields['user_name']), $id);

        $this->session->collection()->set('sid', $this->mSession->getSid());

        return $id;
    }

    public function signIn(array $fields)
    {
        $user = $this->mUser->signIn($fields);

        if (isset($fields['remember']) && isset($user['user_name'])) {
            $cookie = new Cookie('user', $user['user_name'], strtotime('+30 days', time()));
            $this->response->setCookie($cookie);
        }

        $sid = $this->mSession->getSidHash($user['user_name']);

        if (!$this->mSession->getBySid($sid)) {
            $this->mSession->set($sid, $user['id']);
        } else {
            $this->mSession->update($sid);
        }

        if (!$this->session->collection()->get('sid', false)) {
            $this->session->collection()->set('sid', $this->mSession->getSid());
        }

        return true;
    }

    public function isAuth(Request $request)
    {
        if ($this->current) {
            return true;
        }

        if ($sid = $this->session->collection()->get('sid')) {
            $this->current = $this->mSession->getBySid($sid);
        }

        if ($this->current) {

            $this->mSession->update($sid);

            return true;
        }

        if ($userName = $request->cookie()->get('user')) {

            $sid = $this->mSession->getSidHash($userName);

            $user = $this->mUser->getByUser(sprintf('user_name = \'%s\'', $userName));

            $this->session->collection()->set('sid', $sid);

            if ($user && $sid && !$this->mSession->getBySid($sid)) {
                $this->mSession->set($sid, $user['id']);
            }

            $this->current = $this->mSession->getBySid($sid);

            return true;
        }

        return false;
        //SELECT users.id as id, user_name, user_password FROM sessions JOIN users ON sessions.id_user = users.id WHERE sid = '123456789'
    }

    public function output()
    {
        $this->session->collection()->remove('sid');
        unset($_SESSION['sid']);

        $cookie = new Cookie('user', '', strtotime('-100 days', time()));
        $this->response->setCookie($cookie);
    }

//    public function checkAccess($priv)
//    {
//        if (!$this->current) {
//            return false;
//        }
//
//        return $this->mRole->checkPriv($priv, $this->current['id']);
//    }

//    public function getSidHash($sid)
//    {
//        $md5 = md5($sid . UsersModel::MD5_ADD);
//        return substr($md5, 1, 10);
//    }

    private function comparePass(array $field)
    {
        return $field['user_password'] === $field['user_password_repeat'];
    }
}