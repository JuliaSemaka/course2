<?php

namespace forms;

use core\Forms\Form;
use core\Request;

class SignIn extends Form
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
                'placeholder' => 'Enter your password',
                'value' => $request->post('user_password')
            ],
            [
                'name' => 'remember',
                'type' => 'checkbox',
                'value' => 'Запомнить'
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