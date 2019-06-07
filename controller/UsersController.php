<?php

namespace controller;

use core\DBDriver;
use core\User;
use core\Validator;
use models\UsersModel;
use core\DB;
use core\Exception\ModelIncorrectDataException;

class UsersController extends BaseController
{
    public function signUpAction()
    {
        $this->title .= '::Регистрация';

        if($this->request->isGet()){
            $this->content = $this->build(NewsController::ROOT . 'sign_up.html.php', []);
        }

        if($this->request->isPost()){
            $mUsers = new UsersModel(
                new DBDriver(DB::db_connect()),
                new Validator()
            );

            $user = new User($mUsers);

            try {
                $user->signUp($this->request->post());
                $this->redirect('/');
            } catch (ModelIncorrectDataException $e) {
                $this->content = $this->build(NewsController::ROOT . 'sign_up.html.php', ['err' => $e->getErrors(), 'user' => $this->request->post()]);
            }


//            try {
//                $mUsers->addNew([
//                    'user_name' => $this->request->post('user_name'),
//                    'user_password' => $this->request->post('user_password')
//                ]);
//                $this->redirect('/');
//            } catch (ModelIncorrectDataException $e) {
//                $err['errors'] = $e->getErrors();
//                $err['user_name'] = $this->request->post('user_name');
//                $err['user_password'] = $this->request->post('user_password');
//                $err['user_password_repeat'] = $this->request->post('user_password_repeat');
//                $this->content = $this->build(NewsController::ROOT . 'sign_up.html.php', ['err' => $err]);
//            }
        }
    }
}