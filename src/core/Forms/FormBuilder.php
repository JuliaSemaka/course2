<?php

namespace JuliaYatsko\course2\core\Forms;

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
//        $errors = [];

        foreach ($this->form->getFields() as $field) {
            switch ($field['type']) {
                case 'textarea':
                    $fields[] = $this->textarea($field);
                    break;
                default:
                    $fields[] = $this->input($field);
                    break;
            }
        }

        return $fields;
    }

    public function input(array $attributes)
    {
        $errors = [];
        if (isset($attributes['errors'])) {
            $class = $attributes['class'];
            $attributes['class'] = trim(sprintf('%s error', $class));
            $errors = $attributes['errors'];

            unset($attributes['errors']);
        }

        $text = null;
        if (isset($attributes['text'])) {
            $text = $attributes['text'];

            unset($attributes['text']);
        }

        $input =  sprintf('<input %s>', $this->buildAttributes($attributes));

        if ($text) {
            $input = sprintf('<label>%s%s</label>', $input, $text);
        }

        if ($errors) {
            foreach ($errors as $err) {
                $input = sprintf('%s<div style = "color: red; font-size: 10px; font-style: italic;">%s</div>', $input, $err);
            }
        }

        return $input;
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