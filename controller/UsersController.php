<?php

namespace controller;

use core\DBDriver;
use core\User;
use core\Validator;
use models\SessionModel;
use models\UsersModel;
use core\DB;
use core\Exception\ModelIncorrectDataException;
use forms\SignUp;
use core\Forms\FormBuilder;

class UsersController extends BaseController
{
    public function signUpAction()
    {
        $this->title .= '::Регистрация';

        $form = new SignUp($this->request);
        $formBuilder = new FormBuilder($form);

//        if($this->request->isGet()){
//            $this->content = $this->build(NewsController::ROOT . 'sign_up.html.php', []);
//        }

        if($this->request->isPost()){
            $mUsers = new UsersModel(
                new DBDriver(DB::db_connect()),
                new Validator()
            );

            $mSession = new SessionModel(
                new DBDriver(DB::db_connect()),
                new Validator()
            );

            $user = new User($mUsers, $mSession);

            try {
                $user->signUp($form->handleRequest($this->request));
                $this->redirect('/');
            } catch (ModelIncorrectDataException $e) {
                $form->addErrors($e->getErrors());
            }
        }

        $this->content = $this->build(NewsController::ROOT . 'sign_up.html.php', ['form' => $formBuilder]);
    }

    public function signInAction()
    {
        $this->title .= '::Авторизация';

//        if($this->request->isGet()){
//            $this->content = $this->build(NewsController::ROOT . 'sign_in.html.php', []);
//        }
        $err = '';

        if($this->request->isPost()){
            $mUsers = new UsersModel(
                new DBDriver(DB::db_connect()),
                new Validator()
            );
            $mSession = new SessionModel(
                new DBDriver(DB::db_connect()),
                new Validator()
            );

            $user = new User($mUsers, $mSession);

            try {
                $user->signIn($this->request->post());
                $this->redirect('/');
            } catch (ModelIncorrectDataException $e) {
                $err = $e->getErrors();
            }

        }

//        var_dump('111111');
//        die;
        $this->content = $this->build(NewsController::ROOT . 'sign_in.html.php', ['err' => $err, 'user' => $this->request->post()]);
    }
}