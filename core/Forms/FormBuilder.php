<?php

namespace Core\Forms;

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
        foreach ($this->form->getFields() as $field) {
            $inputs[] = $this->input($field);
        }

        return $inputs;
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
        $errors = '<div style = "color: red; font-size: 10px; font-style: italic;">' . implode('</div><div style = "color: red; font-size: 10px; font-style: italic;">', $errors) . '</div>';

        return sprintf('<input %s>%s', $this->buildAttributes($attributes), $errors);
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