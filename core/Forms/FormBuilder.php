<?php

namespace Core\Forms;

use core\Exception\ErrorNotFoundException;

class FormBuilder
{
    public $form;

    public function __construct(Form &$form)
    {
        $this->form = $form;
    }

    public function method()
    {
        $method = $this->form->getMethod();

        if (null === $method) {
            $method = 'GET';
        }

        return sprintf('method="%s"', $method);
    }

    public function buildClass()
    {
        $buildClass = $this->form->getClass();

        if (null === $buildClass) {
            return null;
        }

        return sprintf('class="%s"', $buildClass);
    }

    public function fields()
    {
        $fields = [];
        $errors = [];

        foreach ($this->form->getFields() as $field) {
            if (isset($field['errors'])) {
                $class = $field['class'];
                $field['class'] = trim(sprintf('%s error', $class));
                $errors = $field['errors'];

                unset($field['errors']);
            }

            switch ($field['type']) {
                case 'checkbox':
                    $fields[] = $this->checkbox($field);
                    break;
                case 'textarea':
                    $fields[] = $this->textarea($field);
                    break;
                case 'error':
                    $fields[] = $this->divError($field);
                    break;
                default:
                    $fields[] = $this->input($field);
                    break;
            }

            if (is_array($errors)) {
                foreach ($errors as $err) {

                    $attr['value'] = $err;
                    $fields[] = $this->divError($attr);
                }
                unset($errors);
            }
        }

        return $fields;
    }

    public function input(array $attributes)
    {
        return sprintf('<input %s>', $this->buildAttributes($attributes));
    }

    public function checkbox(array $attributes)
    {
        $value = '';
        if (isset($attributes['value'])) {
            $value = $attributes['value'];

            unset($attributes['value']);
        }

        return sprintf('<input %s>%s', $this->buildAttributes($attributes), $value);
    }

     public function textarea(array $attributes)
    {
        $value = '';
        unset($attributes['type']);

        if (isset($attributes['value'])) {
            $value = $attributes['value'];

            unset($attributes['value']);
        }

        return sprintf('<textarea %s>%s</textarea>', $this->buildAttributes($attributes), $value);
    }

     public function divError(array $attributes)
    {
        $value = '';
        if (isset($attributes['type'])) {
            unset($attributes['type']);
        }

        if (isset($attributes['value'])) {
            $value = $attributes['value'];

            unset($attributes['value']);
        }

        return sprintf('<div style = "color: red; font-size: 10px; font-style: italic;" %s>%s</div>', $this->buildAttributes($attributes), $value);
    }

    public function inputSign()
    {
        return $this->input([
            'type' => 'hidden',
            'name' => 'sign',
            'value' => $this->form->getSign()
        ]);
    }

    private function buildAttributes(array $attributes)
    {
        $arr = [];
        foreach ($attributes as $attribute => $value) {
            $arr[] = sprintf('%s="%s"', $attribute, $value);
        }

        return implode(' ', $arr);
    }
}