<?php

namespace JuliaYatsko\course2\forms;

use JuliaYatsko\course2\core\Forms\Form;

class SignIn extends Form
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
                'placeholder' => 'Enter your password'
            ],
            [
                'name' => 'remember',
                'type' => 'checkbox',
                'text' => 'Запомнить'
            ],
            [
                'type' => 'submit',
                'value' => 'Войти'
            ]
        ];

        $this->formName = 'sign-in';
        $this->method = 'POST';
        $this->class = 'form sign-in';
    }
}