<?php

namespace JuliaYatsko\course2\controller;

use JuliaYatsko\course2\forms\SignIn;
use JuliaYatsko\course2\core\Exception\ModelIncorrectDataException;
use JuliaYatsko\course2\forms\SignUp;
use JuliaYatsko\course2\core\Forms\FormBuilder;

class UsersController extends BaseController
{
    public function signUpAction()
    {
        $this->title .= '::Регистрация';

        $form = new SignUp();
        $formBuilder = new FormBuilder($form);

        if($this->request->isPost()){

//            $mUsers = new UsersModel(
//                $this->container->get('db-driver'),
//                new Validator()
//            );
//            $mUsers = $this->container->fabricate('factory-models', 'UsersModel');
//            $mSession = new SessionModel(
//                $this->container->get('db-driver'),
//                new Validator()
//            );
//            $mSession = $this->container->fabricate('factory-models', 'SessionModel');
//            $user = new User($mUsers, $mSession, $this->request);

            $user = $this->container->fabricate('user', $this->request);

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

        $form = new SignIn();
        $formBuilder = new FormBuilder($form);

//        $mUsers = $this->container->fabricate('factory-models', 'UsersModel');
//        $mSession = $this->container->fabricate('factory-models', 'SessionModel');

        $user = $this->container->fabricate('user', $this->request);

        if ($user->isAuth()) {
//            $this->redirect('/');
        }

        if($this->request->isPost()){

//            $user->isAuth($this->request);

            try {
                $user->signIn($form->handleRequest($this->request));
                $this->redirect('/');
            } catch (ModelIncorrectDataException $e) {
                $form->addErrors($e->getErrors());
            }
        }

        $this->content = $this->build(NewsController::ROOT . 'sign_in.html.php', ['form' => $formBuilder]);
    }
}