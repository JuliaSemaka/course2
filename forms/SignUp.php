<?php

namespace forms;

use core\Forms\Form;
use core\Request;

class SignUp extends Form
{
    public function __construct(Request $request)
    {
        $this->fields = [
            [
                'name' => 'user_name',
                'type' => 'text',
                'placeholder' => 'Enter your login',
                'class' => 'class-class',
                'value' => $request->post('user_name')
            ],
            [
                'name' => 'user_password',
                'type' => 'password',
                'placeholder' => 'Введите пароль',
                'value' => $request->post('user_password')
            ],
            [
                'name' => 'user_password_repeat',
                'type' => 'password',
                'placeholder' => 'Повторите пароль',
                'value' => $request->post('user_password_repeat')
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