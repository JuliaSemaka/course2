<?php

namespace JuliaYatsko\course2\core\Forms;

use JuliaYatsko\course2\core\http\Request;

abstract class Form
{
    protected $formName;
    protected $action;
    protected $method;
    protected $fields;
    protected $class;

    public function getName()
    {
        return $this->formName;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getFields()
    {
        return new \ArrayIterator($this->fields);
    }

    public function getClass()
    {
        return $this->class;
    }

    public function handleRequest(Request $request)
    {
        $fields = [];
        $string = '';

        foreach ($this->getFields() as $key => $field)
        {
            if (!isset($field['name'])) {
                continue;
            }

            $name = $field['name'];

            if ($request->post()->get($name) !== null) {

                if ($this->fields[$key]['type'] === 'checkbox') {
                    $this->setAttribute($key, 'checked', 'checked');
                }

                $this->setAttribute($key, 'value', $request->post()->get($name));
                $fields[$name] = $request->post()->get($name);
            }
        }

        if (null !== $request->post()->get('sign') && $this->getSign() !== $request->post()->get('sign')){
            die('Формы не совпадают');
        }

        return $fields;
    }

    public function setAttribute($key, $attrName, $attrValue)
    {
        $this->fields[$key][$attrName] = $attrValue;
    }

    public function getSign()
    {
        $string = '';
        foreach ($this->getFields() as $field) {
            if (isset($field['name'])){
                $string .= '/#@=@/' . $field['name'];
            }
        }

        return md5($string);
    }

    public function addErrors(array $errors)
    {
        foreach ($this->fields as $key => $field) {
            $name = $field['name'] ? $field['name'] : null;
            if(isset($errors[$name])) {
                $this->setAttribute($key, 'errors', $errors[$name]);
            }
        }
    }

}