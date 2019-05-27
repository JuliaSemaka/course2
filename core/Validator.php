<?php

namespace core;

use core\Exception\ValidatorException;

class Validator
{
    public $clean = [];
    public $errors = [];
    public $success = false;
    protected $rules;
    const INT = 'int';
    const INTEGER = 'integer';
    const STRING = 'string';

    public function execute(array $field)
    {
        if (!$this->rules) {
            throw new ValidatorException('Rules for validation not found', 500);
        }

        foreach ($this->rules as $name => $rule) {
            //не существует обязательного поля
            if (!isset($field[$name])  && isset($rule['require'])) {
                $this->errors[$name][] = sprintf('Field %s is require!', $name);
            }

            //не существует поля и оно не обязательно
            if (!isset($field[$name]) && (!isset($rule['require']) || !$rule['require'])) {
				continue;
            }

            if (isset($rule['type']) && !$this->isTypeMatching($field[$name], $rule['type'])) {
                $this->errors[$name][] = sprintf('Field %s must be a %s type', $name, $rule['type']);
            }

            if (isset($rule['length']) && !$this->isLengthMatching($field[$name], $rule['length'])) {
                $this->errors[$name][] = sprintf('Field %s has an incorrect length', $name);
            }

            if (isset($rule['not_blank']) && $rule['not_blank'] && $this->isBlank($field[$name])) {
                $this->errors[$name][] = sprintf('Field %s should not be empty', $name);
            }

            if (empty($this->errors[$name]) && isset($field[$name])) {
                if (isset($rule['type']) && $rule['type'] === STRING) {
                    $this->clean[$name] = htmlspecialchars(trim($field[$name]));
                } elseif (isset($rule['type']) && $rule['type'] === INTEGER || $rule['type'] === INT) {
                    $this->clean[$name] = (int)$field[$name];
                } else {
                    $this->clean[$name] = $field[$name];
                }
            }
        }
//        echo "<pre>";
//        var_dump($this->errors, $this->clean);
//        die;
//        echo "</pre>";

        if (empty($this->errors)) {
            $this->success = true;
        }


    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function isBlank($field)
    {
        $field = trim($field);
        return $field === null || $field === '';
    }

    public function isTypeMatching($field, $type)
    {
        switch ($type) {
            case self::STRING:
                return is_string($field);
                break;
            case self::INT:
            case self::INTEGER:
                return gettype($field) === self::INTEGER || ctype_digit($field);
                break;
            default:
                throw new ValidatorException('Incorrect type given to method isTypeMatching');
                break;
        }
    }

    public function isLengthMatching($field, $length)
    {
        if($isArray = is_array($length)) {
            $max = isset($length[1]) && $this->isTypeMatching($length[1], self::INT) ? $length[1] : false;
            $min = isset($length[0]) && $this->isTypeMatching($length[0], self::INT) ? $length[0] : false;
        } else {
            $max = $this->isTypeMatching($length, self::INT) ? $length : false;
            $min = false;
        }

        if($isArray && (!$max || !$min)) {
            throw new ValidatorException('Incorrect data given to method isLengthMatch');
        }

        if(!$isArray && !$max) {
            throw new ValidatorException('Incorrect data given to method isLengthMatch');
        }

        $maxIsMatch = $max ? $this->isLengthMaxMatch($field, $max) : false;
        $minIsMatch = $min ? $this->isLengthMinMatch($field, $min) : false;

        return $isArray ? $maxIsMatch && $minIsMatch : $maxIsMatch;
    }

    public function isLengthMaxMatch($field, $length) {
        if (!$this->isTypeMatching($length, self::INT)) {
            return false;
        }
        return mb_strlen($field) > $length === false;
    }

    public function isLengthMinMatch($field, $length) {
        if (!$this->isTypeMatching($length, self::INT)) {
            return false;
        }
        return mb_strlen($field) < $length === false;
    }
}