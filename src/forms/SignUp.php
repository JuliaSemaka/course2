<?php

namespace Project\Phpblog\forms;

use Project\Phpblog\core\Forms\Form;

class SignUp extends Form
{
    public function __construct()
    {
        $this->fields = [
            [
                'name' => 'user_name',
                'type' => 'text',
                'placeholder' => 'Enter your login',
                'class' => 'class-class'
            ],
            [
                'name' => 'user_password',
                'type' => 'password',
                'placeholder' => 'Enter your login'
            ],
            [
                'name' => 'user_password_repeat',
                'type' => 'password',
                'placeholder' => 'Повторите пароль'
            ],
            [
                'type' => 'submit',
                'value' => 'Зарегистрироваться'
            ]
        ];

        $this->formName = 'sign-up';
        $this->method = 'POST';
        $this->class = 'form sign-up';
    }
}